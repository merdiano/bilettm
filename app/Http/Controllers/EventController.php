<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\EventStats;
use App\Models\Organiser;
use App\Models\Ticket;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;
use Log;
use Validator;
use Spatie\GoogleCalendar\Event as GCEvent;

class EventController extends MyBaseController
{
    public function getMain(){
        return Category:: main()
            ->whereHas('events')
            ->categoryLiveEvents(10)
            ->get();

    }

    public function index(Request $request){

        return Event::select('id','title_ru','title_tk')
            ->onLive($request->get('start_date'),$request->get('end_date'))
            ->paginate(20);
    }

    public function getEvent($id){

        //todo handle if not found
        $event = Event::select(
            "id",
            "description_ru",
            "description_tk",
            "start_date",
            "end_date","venue_id")
            ->with(['ticket_dates','venue:id,venue_name_tk,venue_name_ru,address'])
            ->WithViews()
            ->where('id',$id)

            ->first();


        $ticket_dates = array();

        foreach ($event->ticket_dates as $ticket){
            $date = $ticket->ticket_date->format('Y-m-d');
            $ticket_dates[$date][] = $ticket;
        }

        return response()->json([
            'event' => $event,
            'tickets' => $ticket_dates,
        ]);
    }

    public function getEventSeats(Request $request,$event_id){
        $this->validate($request,['ticket_date'=>'required|date']);
        $event = Event::with('venue:id,venue_name,seats_image,address,venue_name_ru,venue_name_tk')
            ->findOrFail($event_id,['id','venue_id']);

        $tickets = Ticket::WithSection($event_id, $request->get('ticket_date'))
//            ->where('end_sale_date','>',Carbon::now())
//            ->where('start_sale_date','<',Carbon::now())
//            ->where('is_hidden', false)
//            ->where('is_paused', false)
            ->orderBy('sort_order','asc')
            ->get();

        return $tickets;
        if($tickets->count()==0)
            return response()->json([
               'status' => 'error',
               'message' => 'There is no tickets available'
            ]);

        return response()->json([
            'status' => 'success',
            'venue' => $event->venue,
            'tickets' => $tickets
        ]);
    }

    public function search(Request $request){
        $key = $request->get('key');
        return Event::select('id','title_ru','title_tk')
            ->onLive()
            ->where('title_ru','like',"%{$key}%")
            ->orWhere('title_tk','like',"%{$key}%")
            ->paginate(10);
    }

    public function getVendorEvents(Request $request){
         $data = $request->auth->events()
             ->select('id','title_ru','title_tk','start_date','end_date',"sales_volume","organiser_fees_volume","is_live")
             ->where('end_date','>', Carbon::now())
             ->WithViews()
             ->withCount(['attendees as sold_count' => function($q){
                 $q->where('is_cancelled',false);
             }])
             ->with('ticket_dates')
             ->withCount(['images as image_url' => function($q){
                 $q->select(DB::raw("image_path as imgurl"))
                     ->orderBy('created_at','desc')
                     ->limit(1);
            }] )
             ->orderBy('id','DESC')
             ->get();

         return response()->json(['data'=>$data]);
    }

    public function getVendorEvent(Request $request,$event_id){
        return Event::with(['ticket_dates','sections'])
            ->select("id", 'start_date','end_date',"sales_volume","organiser_fees_volume","is_live")
            ->WithViews()
            ->withCount(['images as image_url' => function($q){
                $q->select(DB::raw("image_path as imgurl"))
                    ->orderBy('created_at','desc')
                    ->limit(1);
            }] )
            ->where('id',$event_id)
            ->where('user_id',$request->auth->id)
            ->first();
    }

    public function getVendorEventSeats(Request $request,$event_id){
        $this->validate($request,['ticket_date'=>'required|date']);

        $tickets = Ticket::WithSection($event_id, $request->get('ticket_date'))
            ->get();

        return response()->json([
            'status' => 'success',
            'tickets' => $tickets
        ]);
    }
    
    /**
     * Show the 'Create Event' Modal
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showCreateEvent(Request $request)
    {

        $data = [
            'modal_id'     => $request->get('modal_id'),
            'organisers'   => Organiser::scope()->pluck('name', 'id'),
            'categories'   => Category::pluck(trans('Category.category_title'),'id'),
            'organiser_id' => $request->get('organiser_id') ? $request->get('organiser_id') : false,
        ];
//        dd($data);
        return view('ManageOrganiser.Modals.CreateEvent', $data);
    }

    /**
     * Create an event
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateEvent(Request $request)
    {
        $event = Event::createNew();

        if (!$event->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $event->errors(),
            ]);
        }

        $event->title_ru = $request->get('title_ru');
        $event->title_tk = $request->get('title_tk')?:$request->get('title_ru');
        $event->description_ru = strip_tags($request->get('description_ru'));
        $event->description_tk = strip_tags($request->get('description_tk')?:$request->get('description_ru'));
        $event->start_date = $request->get('start_date');
        $event->category_id = $request->get('category_id');
        $event->sub_category_id = $request->get('sub_category_id');
        /*
         * Venue location info (Usually auto-filled from google maps)
         */

        $is_auto_address = (trim($request->get('place_id')) !== '');
        $event->venue_id = $request->get('venue_id');
//        if ($is_auto_address) { /* Google auto filled */
//            $event->venue_name = $request->get('name');
//            $event->venue_name_full = $request->get('venue_name_full');
//            $event->location_lat = $request->get('lat');
//            $event->location_long = $request->get('lng');
//            $event->location_address = $request->get('formatted_address');
//            $event->location_country = $request->get('country');
//            $event->location_country_code = $request->get('country_short');
//            $event->location_state = $request->get('administrative_area_level_1');
//            $event->location_address_line_1 = $request->get('route');
//            $event->location_address_line_2 = $request->get('locality');
//            $event->location_post_code = $request->get('postal_code');
//            $event->location_street_number = $request->get('street_number');
//            $event->location_google_place_id = $request->get('place_id');
//            $event->location_is_manual = 0;
//        } else { /* Manually entered */
//            $event->venue_name = $request->get('location_venue_name');
//            $event->location_address_line_1 = $request->get('location_address_line_1');
//            $event->location_address_line_2 = $request->get('location_address_line_2');
//            $event->location_state = $request->get('location_state');
//            $event->location_post_code = $request->get('location_post_code');
//            $event->location_is_manual = 1;
//        }

        $event->end_date = $request->get('end_date');

//        $event->currency_id = Auth::user()->account->currency_id;
        //$event->timezone_id = Auth::user()->account->timezone_id;
        /*
         * Set a default background for the event
         */
        $event->bg_type = 'image';
        $event->bg_image_path = config('attendize.event_default_bg_image');


        if ($request->get('organiser_name')) {
            $organiser = Organiser::createNew(false, false, true);

            $rules = [
                'organiser_name'  => ['required'],
                'organiser_email' => ['required', 'email'],
            ];
            $messages = [
                'organiser_name.required' => trans("Controllers.no_organiser_name_error"),
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => 'error',
                    'messages' => $validator->messages()->toArray(),
                ]);
            }

            $organiser->name = $request->get('organiser_name');
            $organiser->about = $request->get('organiser_about');
            $organiser->email = $request->get('organiser_email');
            $organiser->facebook = $request->get('organiser_facebook');
            $organiser->twitter = $request->get('organiser_twitter');
            $organiser->save();
            $event->organiser_id = $organiser->id;
        } elseif ($request->get('organiser_id')) {
            $event->organiser_id = $request->get('organiser_id');
        } else { /* Somethings gone horribly wrong */
            return response()->json([
                'status'   => 'error',
                'messages' => trans("Controllers.organiser_other_error"),
            ]);
        }

        /*
         * Set the event defaults.
         * @todo these could do mass assigned
         */
        $defaults = $event->organiser->event_defaults;
        if ($defaults) {
            $event->organiser_fee_fixed = $defaults->organiser_fee_fixed;
            $event->organiser_fee_percentage = $defaults->organiser_fee_percentage;
            $event->pre_order_display_message = $defaults->pre_order_display_message;
            $event->post_order_display_message = $defaults->post_order_display_message;
            $event->offline_payment_instructions = $defaults->offline_payment_instructions;
            $event->enable_offline_payments = $defaults->enable_offline_payments;
            $event->social_show_facebook = $defaults->social_show_facebook;
            $event->social_show_linkedin = $defaults->social_show_linkedin;
            $event->social_show_twitter = $defaults->social_show_twitter;
            $event->social_show_email = $defaults->social_show_email;
            $event->social_show_googleplus = $defaults->social_show_googleplus;
            $event->social_show_whatsapp = $defaults->social_show_whatsapp;
            $event->is_1d_barcode_enabled = $defaults->is_1d_barcode_enabled;
            $event->ticket_border_color = $defaults->ticket_border_color;
            $event->ticket_bg_color = $defaults->ticket_bg_color;
            $event->ticket_text_color = $defaults->ticket_text_color;
            $event->ticket_sub_text_color = $defaults->ticket_sub_text_color;
        }


        try {
            $event->save();
            $event_stats = new EventStats();
            $event_stats->updateViewCount($event->id);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json([
                'status'   => 'error',
                'messages' => trans("Controllers.event_create_exception"),
            ]);
        }

        if ($request->hasFile('event_image')) {
            $path = public_path() . '/' . config('attendize.event_images_path');
            $filename = 'event_image-' . md5(time() . $event->id) . '.' . strtolower($request->file('event_image')->getClientOriginalExtension());

            $file_full_path = $path . '/' . $filename;

            $request->file('event_image')->move($path, $filename);

            $img = Image::make($file_full_path);

            $img->resize(406, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save($file_full_path);

            /* Upload to s3 */
            \Storage::put(config('attendize.event_images_path') . '/' . $filename, file_get_contents($file_full_path));

            $eventImage = EventImage::createNew();
            $eventImage->image_path = config('attendize.event_images_path') . '/' . $filename;
            $eventImage->event_id = $event->id;
            $eventImage->save();
        }

        return response()->json([
            'status'      => 'success',
            'id'          => $event->id,
            'redirectUrl' => route('showEventTickets', [
                'event_id'  => $event->id,
                'first_run' => 'yup',
            ]),
        ]);
    }

    /**
     * Edit an event
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEditEvent(Request $request, $event_id)
    {
        $event = Event::scope()->findOrFail($event_id);

        if (!$event->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $event->errors(),
            ]);
        }

        $event->is_live = $request->get('is_live');
//        $event->currency_id = $request->get('currency_id');
        $event->title_ru = $request->get('title_ru');
        $event->title_tk = $request->get('title_tk');
        $event->description_ru = strip_tags($request->get('description_ru'));
        $event->description_tk = strip_tags($request->get('description_tk'));
        $event->start_date = $request->get('start_date');
        $event->category_id = $request->get('category_id');
        $event->sub_category_id = $request->get('sub_category_id');
        $event->google_tag_manager_code = $request->get('google_tag_manager_code');

        $event->venue_id = $request->get('venue_id');

        $event->end_date = $request->get('end_date');
        $event->event_image_position = $request->get('event_image_position');

        if ($request->get('remove_current_image') == '1') {
            EventImage::where('event_id', '=', $event->id)->delete();
        }

        $event->save();

        if ($request->hasFile('event_image')) {
            $path = public_path() . '/' . config('attendize.event_images_path');
            $filename = 'event_image-' . md5(time() . $event->id) . '.' . strtolower($request->file('event_image')->getClientOriginalExtension());

            $file_full_path = $path . '/' . $filename;

            $request->file('event_image')->move($path, $filename);

            $img = Image::make($file_full_path);

            $img->resize(406, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save($file_full_path);

            \Storage::put(config('attendize.event_images_path') . '/' . $filename, file_get_contents($file_full_path));

            EventImage::where('event_id', '=', $event->id)->delete();

            $eventImage = EventImage::createNew();
            $eventImage->image_path = config('attendize.event_images_path') . '/' . $filename;
            $eventImage->event_id = $event->id;
            $eventImage->save();
        }

        return response()->json([
            'status'      => 'success',
            'id'          => $event->id,
            'message'     => trans("Controllers.event_successfully_updated"),
            'redirectUrl' => '',
        ]);
    }

    /**
     * Upload event image
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUploadEventImage(Request $request)
    {
        if ($request->hasFile('event_image')) {
            $the_file = \File::get($request->file('event_image')->getRealPath());
            $file_name = 'event_details_image-' . md5(microtime()) . '.' . strtolower($request->file('event_image')->getClientOriginalExtension());

            $relative_path_to_file = config('attendize.event_images_path') . '/' . $file_name;
            $full_path_to_file = public_path() . '/' . $relative_path_to_file;

            $img = Image::make($the_file);

            $img->resize(406, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save($full_path_to_file);
            if (\Storage::put($file_name, $the_file)) {
                return response()->json([
                    'link' => '/' . $relative_path_to_file,
                ]);
            }

            return response()->json([
                'error' => trans("Controllers.image_upload_error"),
            ]);
        }
    }

    /**
     * Puplish event and redirect
     * @param  Integer|false $event_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeEventLive($event_id = false) {
        $event = Event::scope()->findOrFail($event_id);
        $event->is_live = 1;
        $event->save();
        \Session::flash('message', trans('Event.go_live'));

        return redirect()->action(
            'EventDashboardController@showDashboard', ['event_id' => $event_id]
        );
    }
}
