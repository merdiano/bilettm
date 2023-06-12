<?php
/**
 * Created by PhpStorm.
 * User: merdan
 * Date: 12/9/2018
 * Time: 12:39 PM
 */

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\SubscribeRequest;
use App\Models\EventRequest;
use App\Models\Subscriber;
use App\Models\Category;
use App\Models\Event;
use App\Models\Slider;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Validator;

class PublicController extends Controller
{
    public function showHomePage(){
        $cinema = Category::categoryLiveEvents(8,'cinema')
            ->take(1);

        $cartoon = Category::categoryLiveEvents(8,'exhibition')
            ->take(1);

        $musical = Category::categoryLiveEvents(8,'concert')
            ->take(1);

        $circus = Category::categoryLiveEvents(8,'circus')
            ->take(1);

        $categories = $cinema->unionAll($musical)->unionAll($cartoon)->unionAll($circus)->get();

        dd($categories);
        $sliders = Slider::where('active',1)
            ->where(Config::get('app.locale'),1)
            ->orderBy('order','asc')
            ->get();
        return $this->render("Pages.HomePage",[
            'categories' => $categories,
            'sliders' => $sliders
        ]);

    }

    public function showCategoryEvents($cat_id){

        [$order, $data] = $this->sorts_filters();

        $locale = Config::get('app.locale');

        $category = Category::select('id',"title_{$locale}")
            ->with(['children'=>function($q) use($data,$locale){

                $q->select('id','parent_id','events_limit','view_type',"title_{$locale}");

                $q->withCount(['cat_events' => function ($query) use($data) {

                    $query->onLive($data['start'], $data['end']);

                }]);

                $q->whereHas('cat_events',
                    function ($query) use($data){

                        $query->onLive($data['start'], $data['end']);

                })->orderBy('cat_events_count','desc');

            }])->findOrFail($cat_id);

        $data['category'] = $category;

        // get all live events belong to sub categories

        if($category->children->count()){

            $sub_cat_last = $category->children->pop();

            $sub_cats_events = $sub_cat_last->cat_events()
                ->onLive($data['start'],$data['end'])
                ->orderBy($order['field'],$order['order'])
                ->take($sub_cat_last->events_limit);

            foreach ($category->children as $sub_cat){

                $events_query = $sub_cat->cat_events()
                    ->onLive($data['start'],$data['end'])
                    ->orderBy($order['field'],$order['order'])
                    ->take($sub_cat->events_limit);

                $sub_cats_events = $sub_cats_events->unionAll($events_query);
            }

            $category->children->push($sub_cat_last);

            $data['events'] = $sub_cats_events->get();
        }

        return $this->render("Pages.EventsPage",$data);
    }

    public function showSubCategoryEvents($cat_id){
        $category = Category::select('id','title_tk','title_ru','view_type','events_limit','parent_id')
            ->findOrFail($cat_id);

        [$order, $data] = $this->sorts_filters();

        $data['category'] = $category;

        $data['events'] = $category->cat_events()
            ->onLive($data['start'],$data['end'])
            ->orderBy($order['field'],$order['order'])
            ->paginate(16);

        return $this->render("Pages.CategoryEventsPage",$data);
    }

    private function sorts_filters(){

        $data['start'] = \request()->get('start');

        $data['end'] = \request()->get('end');

        $sort = \request()->get('sort');

        if($sort == 'new')
            $orderBy = ['field'=>'created_at','order'=>'desc'];

        if ($sort =='popular') {

            $orderBy = ['field' => 'views', 'order' => 'desc'];
        }
        else {

            $orderBy =['field'=>'start_date','order'=>'asc'];

            $sort = 'start_date';
        }

        $data['sort'] = $sort;
        //todo check date formats;
        return [$orderBy, $data];
    }

    public function search(SearchRequest $request){
        //todo implement with elastick search and scout
        $query = sanitise($request->get('q'));

        $lc = config('app.locale');
        $events = Event::select('events.id',"events.title_{$lc}",'events.start_date','events.end_date',"events.description_{$lc}",
                "venues.venue_name_{$lc} as venue_name","categories.title_{$lc} as category_title","organisers.name as organiser")
            ->join('venues','venues.id','=','events.venue_id')
            ->join('categories','categories.id','=','events.category_id')
            ->join('organisers','organisers.id','=','events.organiser_id')
//            ->withCount(['stats as views' => function($q){
//                $q->select(DB::raw("SUM(views) as v"));}])
            ->onLive()
            ->where(function ($q) use($query){
                $q->where('events.title_'.config('app.locale'),'like',"%{$query}%")
                    ->orWhere('venues.venue_name_'.config('app.locale'),'like',"%{$query}%")
                    ->orWhere('categories.title_'.config('app.locale'),'like',"%{$query}%")
                    ->orWhere('organisers.name','like',"%{$query}%");
            })->paginate(12);

        return $this->render('Pages.SearchResults',[
            'events' => $events,
            'query' => $query
        ]);
    }

    public function postAddEvent(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|min:2|max:255',
            'phone'=>'required|numeric|digits_between:8,12',
            'email' =>'required|email',
            'details' => 'required|string',
            'place' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $addEvent = EventRequest::create([
            'name' => sanitise($request->get('name')),
            'email' => sanitise($request->get('email')),
            'phone' => sanitise($request->get('phone')),
            'details' => sanitise($request->get('details')),
            'place' => sanitise($request->get('place'))
        ]);

        if($addEvent)
            return response()->json([
                'status'   => 'success',
                'message' => trans('ClientSide.add_event_success_message'),
            ]);
        else
            return response()->json([
                'status'   => 'error',
                'message' => trans('ClientSide.add_event_error_message'),
            ]);
    }

    public function subscribe(SubscribeRequest $request){
        $email = sanitise($request->get('email'));
        //todo validate email
        $subscribe = Subscriber::updateOrCreate(['email'=>$email,'active'=>1]);

        if($subscribe)
            return response()->json([
                'status'   => 'success',
                'message' => trans('ClientSide.subscribe_success_message'),
            ]);
        else
            return response()->json([
                'status'   => 'error',
                'message' => trans('ClientSide.subscribe_error_message'),
            ]);
    }

    public function venues($id = false){
        $data['venues'] = App\Models\Venue::select('id','venue_name_'.Config::get('app.locale'),
            'description_'.Config::get('app.locale').' as description','address','images')
            ->where('active',1)
            ->orderBy('venue_name_'.Config::get('app.locale'),'ASC')
            ->get();

        $data['current'] = $id ? $data['venues']->where('id',$id)->first() ?? $data['venues']->first(): $data['venues']->first();

        return $this->render('Pages.VenuesPage',$data);
    }
}
