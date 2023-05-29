<?php


namespace App\Http\Controllers;


use App\Models\Attendee;
use App\Models\Event;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/vendor/event/{event_id}/attendees",
    *      tags={"Operator"},
    *      summary="Operator",
    *      description="Operator",
    *      @OA\Parameter(
    *          description="event_id",
    *          in="path",
    *          name="event_id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="2", summary="2"),
    *      ),
    *      @OA\Parameter(
    *          description="ticket_date",
    *          in="query",
    *          name="ticket_date",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="string", value="2023-07-19 11:14:00", summary="2023-07-19 11:14:00"),
    *      ),
    *      @OA\Parameter(
    *          description="token",
    *          in="query",
    *          name="token",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="string", value="...", summary="..."),
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function getAttendees(Request $request, $event_id){

        if(!$request->has('ticket_date'))
            return response()->json(['message'=>'error','message'=>'ticket_date does not exists'],400);

        $ticket_date = $request->get('ticket_date');
        // $attendess = Attendee::join('tickets', 'tickets.id', '=', 'attendees.ticket_id')
        //     ->join('orders','orders.id','=','attendees.order_id')
        //     ->where(function ($query) use ($event_id, $ticket_date) {
        //         $query->where('attendees.event_id', $event_id)
        //             ->whereDate('tickets.ticket_date', Carbon::parse($ticket_date)->format('Y-m-d'))
        //             ->whereTime('tickets.ticket_date', Carbon::parse($ticket_date)->format('H:i:s'))
        //             ->where('attendees.is_cancelled',false);
        //     })
        //     ->get();

        $attendees = Attendee::join('orders','orders.id','=','attendees.order_id')->whereHas('ticket',
        function($q) use ($event_id, $ticket_date){
            $q->where('attendees.event_id', $event_id)
            ->whereDate('ticket_date', Carbon::parse($ticket_date)->format('Y-m-d'))
            ->whereTime('ticket_date', Carbon::parse($ticket_date)->format('H:i:s'))
            ->where('attendees.is_cancelled',false);
        })->get();

        return response()->json(['message' => 'success','attendees' => $attendees]);
    }

    /**
    * @OA\Get(
    *      path="/api/vendor/event/{event_id}/ticket_attendees",
    *      tags={"Operator"},
    *      summary="Operator",
    *      description="Operator",
    *      @OA\Parameter(
    *          description="event_id",
    *          in="path",
    *          name="event_id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="2", summary="2"),
    *      ),
    *      @OA\Parameter(
    *          description="ticket_date",
    *          in="query",
    *          name="ticket_date",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="string", value="2023-07-19 11:14:00", summary="2023-07-19 11:14:00"),
    *      ),
    *      @OA\Parameter(
    *          description="token",
    *          in="query",
    *          name="token",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="string", value="...", summary="..."),
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function getTicketsAttendees(Request $request, $event_id){
        if(!$request->has('ticket_date'))
            return response()->json(['message'=>'error','message'=>'ticket_date does not exists'],400);

        $ticket_date = $request->get('ticket_date');

        $tickets = Ticket::select('id','section_id','event_id')
            ->with(['section','booked','attendees' => function($q){
                $q->select('attendees.id','order_id','attendees.first_name','attendees.last_name',
                    'private_reference_number', 'attendees.email', 'attendees.seat_no',
                    'attendees.reference_index','attendees.has_arrived','attendees.arrival_time','orders.order_reference', 'attendees.is_cancelled')
                    ->join('orders','orders.id','=','attendees.order_id')
                    ->where('attendees.is_cancelled',false);
            }])
            ->where('event_id',$event_id)
            ->where('ticket_date',$ticket_date)
            ->get();

        return response()->json(['message'=>'success','tickets' => $tickets]);
    }


    /**
    * @OA\Schema(
    *    schema="Attendee",
    *    title="TicketType",
    *    @OA\Property(
    *         property="id",
    *         type="number"
    *    ),
    *    @OA\Property(
    *         property="arrival_time",
    *         type="string"
    *    ),
    * )
    * @OA\Schema(
    *     schema="CheckinRequest",
    *     title="Checkin Request",
    *    @OA\Property(
    *         property="token",
    *         type="string"
    *    ),
    *     @OA\Property(
    *        property="attendees",
    *        description="Attendees of the event",
    *        type="array",
    *        collectionFormat="multi",
    *        @OA\Items(
    *             ref="#/components/schemas/Attendee"
    *        ),
    *     ),
    * )
    * @OA\Post(
    *     path="/vendor/events/{event_id}/checkin",
    *     tags={"Operator"},
    *     summary="Checkin API",
    *     description="Checkin API",
    *     @OA\Parameter(
    *          description="event_id",
    *          in="path",
    *          name="event_id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="1", summary="1"),
    *     ),
    *     @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/CheckinRequest")
    *     ),
    *     @OA\Response(
    *          response=200,
    *          description="Response Message",
    *     )
    * )
    */
    public function checkInAttendees(Request $request, $event_id){

        $event = Event::where('id',$event_id)->where('user_id',$request->auth->id)->first();

        if(!empty($event) && $request->has('attendees')){
            try{
            $checks = json_decode($request->get('attendees'),true);
            $arrivals = array_column($checks, 'arrival_time', 'id');
            $att_ids = array_column($checks, 'id');

                DB::beginTransaction();
                $attendees = Attendee::whereIn('id',$att_ids)->get();

                foreach ($attendees as $attendee){
                    $attendee->has_arrived = true;
                    $attendee->arrival_time = $arrivals[$attendee->id];
                    $attendee->save();
                }
                DB::commit();

                return response()->json([
                    'message'=>'success'
                ]);

            }catch (\JsonException $ex){
                DB::rollBack();
                return response()->json([
                    'message' => $ex->getMessage(),
                    'attendees' => $request->get('attendees') ,
                ],200);
            }catch (\Exception $ex){

                return response()->json([
                    'message' => $ex->getMessage(),
                    'attendees' => $request->get('attendees')
                ],200);
            }

        }
        else
            return response()->json(['message' => 'provide valid event id and attendees array'],400);
    }

    /**
    * @OA\Get(
    *      path="/api/v2/my_tickets",
    *      operationId="Get tickets registered to phone_id",
    *      tags={"Tickets"},
    *      summary="Get tickets",
    *      description="Get tickets",
    *      @OA\Parameter(
    *          description="phone_id",
    *          in="query",
    *          name="phone_id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="65000000", summary="65000000"),
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function getTickets(Request $request){
        if(!$request->has('phone_id')){
            return response()->json(['status'=>'error','message'=>'phone_id is required'], 400);
        }

        $phone_id = $request->get('phone_id');

        $attendess = Attendee::select('attendees.first_name','attendees.last_name','attendees.email','events.title',
            'private_reference_number', 'seat_no','reference_index','orders.order_reference', 'venues.venue_name','tickets.ticket_date')
            ->join('orders','orders.id','=','attendees.order_id')
            ->join('events','events.id','=','attendees.event_id')
            ->join('venues', 'venues.id', '=', 'events.venue_id')
            ->join('tickets', 'tickets.id', '=', 'attendees.ticket_id')
            ->where(function ($query) use ($phone_id) {
                $query->where('orders.session_id', $phone_id)
                    ->where('orders.is_payment_received',1)
                    ->where('orders.order_status_id',1)
                    ->where('attendees.is_cancelled',0)
                    ->where('orders.is_deleted',0)
                    ->where('orders.is_cancelled',0)
                    ->where('orders.is_partially_refunded',0)
                    ->where('orders.is_refunded',0);
            })
            ->orderBy('attendees.id','DESC')
            ->paginate(20);

        return $attendess;
    }
}
