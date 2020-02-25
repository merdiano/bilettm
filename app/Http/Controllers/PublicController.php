<?php
/**
 * Created by PhpStorm.
 * User: merdan
 * Date: 12/9/2018
 * Time: 12:39 PM
 */

namespace App\Http\Controllers;

use App\Http\Requests\AddEventRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\SubscribeRequest;
use App\Models\EventRequest;
use App\Models\Subscriber;
use App\Models\Category;
use App\Models\Event;
use App\Models\Slider;
use App;
use Illuminate\Support\Facades\Config;

class PublicController extends Controller
{
    public function showHomePage(){
        $cinema = Category::where('view_type','cinema')
            ->categoryLiveEvents(16)
            ->first();

        $cartoon = Category::where('view_type','exhibition')//todo change to cartoon multik
            ->categoryLiveEvents(16)
            ->first();

        $musical =Category::where('view_type','concert')
            ->categoryLiveEvents(8)
            ->first();

        $sliders = Slider::where('active',1)
            ->where(Config::get('app.locale'),1)
            ->get();
//dd($cinema->events->first());
//        return view('desktop.Pages.HomePage')->with([
//            'cinema' => $cinema,
//            'cartoon' => $cartoon,
//            'musical' => $musical,
//            'sliders' => $sliders
//        ]);

        return $this->render("Pages.HomePage",[
            'cinema' => $cinema,
            'cartoon' => $cartoon,
            'musical' => $musical,
            'sliders' => $sliders
        ]);
    }

    public function showCategoryEvents($cat_id){

//        dd(Carbon::parse('aasddwawda') ?? null);/
//        setlocale(LC_TIME, 'tk');
//        Carbon::setLocale('tk');
//        dd(Carbon::parse('2019-01-01',config('app.timezone')) ->formatLocalized('%d %B'));
//        Carbon::
        $category = Category::select('id','title_tk','title_ru','view_type','events_limit','parent_id')
            ->findOrFail($cat_id);

        [$order, $data] = $this->sorts_filters();
        $data['category'] = $category;
        $data['sub_cats'] = $category->children()
            ->withLiveEvents($order, $data['start'], $data['end'], $category->events_limit+2)
            ->whereHas('cat_events',
                function ($query) use($data){
                    $query->onLive($data['start'], $data['end']);
                })
            ->get();

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
        if ($sort =='popular')
            $orderBy = ['field'=>'views','order'=>'desc'];
        else
        {
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
        $events = Event::onLive()
            ->where('title_ru','like',"%{$query}%")
            ->orWhere('title_tk','like',"%{$query}%")
            ->paginate(10);

        return $this->render('Pages.SearchResults',[
            'events' => $events,
            'query' => $query
        ]);
    }

    public function postAddEvent(AddEventRequest $request){

        $addEvent = EventRequest::create([
            'name' => sanitise($request->get('name')),
            'email' => sanitise($request->get('email')),
            'phone' => sanitise($request->get('phone')),
            'detail' => sanitise($request->get('detail'))
        ]);
        return view('desktop.Pages.AddEventResult',compact('addEvent'));
    }

    public function subscribe(SubscribeRequest $request){
        $email = sanitise($request->get('email'));
        //todo validate email
        $subscribe = Subscriber::updateOrCreate(['email'=>$email,'active'=>1]);

        if($subscribe){
            session()->flash('message','Subscription successfully');
        }

        return response()->json([
            'status'   => 'success',
            'message' => 'Subscription successfully',
        ]);
    }
}
