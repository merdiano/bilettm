<?php


namespace App\Http\Controllers;


use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReservedTickets;
use App\Models\Ticket;
use App\Payment\CardPayment;
use App\Services\Order as OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{

    /**
    * @OA\Schema(
    *    schema="TicketType",
    *    title="TicketType",
    *    @OA\Property(
    *         property="ticket_id",
    *         type="integer"
    *    ),
    *    @OA\Property(
    *         property="seat_nos",
    *         description="Seat numbers",
    *         type="array",
    *         collectionFormat="multi",
    *         @OA\Items(type="string", format="id" ),
    *    ),
    * )
    * @OA\Schema(
    *     schema="TicketsRequest",
    *     title="Ticket Request",
    *     @OA\Property(
    *        property="phone_id",
    *        type="integer"
    *     ),
    *     @OA\Property(
    *        property="tickets",
    *        description="Tickets",
    *        type="array",
    *        collectionFormat="multi",
    *        @OA\Items(
    *             ref="#/components/schemas/TicketType"
    *        ),
    *     ),
    * )
    */
    /**
    * @OA\Post(
    *      path="/api/v2/event/{event_id}/reserve",
    *      operationId="Reserve tickets",
    *      tags={"Tickets"},
    *      summary="Reserve tickets",
    *      description="Reserve tickets",
    *      @OA\Parameter(
    *          description="Event ID",
    *          in="path",
    *          name="event_id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="1", summary="1"),
    *      ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/TicketsRequest")
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function postReserveTickets(Request $request,$event_id){
        try {
            if (!$request->has('tickets')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No seats selected',
                ]);
            }

            if (!$request->has('phone_id')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Phone id required'
                ]);
            }

            $order_expires_time = Carbon::now('GMT+5')->addMinutes(5);

            ReservedTickets::where('session_id',$request->get('phone_id'))
                ->whereNull('expects_payment_at')
                ->orWhere('expects_payment_at','<',Carbon::now()->addMinutes(-5))
                ->delete();

            $order_total = 0;
            $booking_fee = 0;
            $organiser_booking_fee = 0;
            $total_ticket_quantity = 0;
            $reserved = [];
            $tickets = [];
            $selectedSeats = $request->get('tickets');

            foreach ($selectedSeats as $ticket) {
                $ticket_id = $ticket['ticket_id'];
                $seats_count = count($ticket['seat_nos']);
                if ($seats_count < 1)
                    continue;

                $seat_nos = $ticket['seat_nos'];
                $reserved_tickets = ReservedTickets::where('ticket_id', $ticket_id)
                    ->where('expires', '>', Carbon::now())
                    ->whereIn('seat_no', $seat_nos)
                    ->pluck('seat_no');

                $booked_tickets = Attendee::where('ticket_id', $ticket_id)
                    ->where('event_id', $event_id)
                    ->whereIn('seat_no', $seat_nos)
                    ->pluck('seat_no');

                if (count($reserved_tickets) > 0 || count($booked_tickets) > 0)
                    return response()->json([
                        'status' => 'error',
                        'messages' => 'Your selected seats are already reserved or booked please choose other seats',//todo show which are reserved
                    ]);

                $eventTicket = Ticket::with('event:id,organiser_fee_fixed,organiser_fee_percentage')
                    ->findOrFail($ticket_id);

                $max_per_person = min($eventTicket->quantity_remaining, $eventTicket->max_per_person);
                

                if ($seats_count < $eventTicket->min_per_person) {
                    $message = 'You must select at least ' . $eventTicket->min_per_person . ' tickets.';
                } elseif ($seats_count > $max_per_person) {
                    $message = 'The maximum number of tickets you can register is ' . $max_per_person;
                }

                if (isset($message)) {
                    return response()->json([
                        'status' => 'error',
                        'messages' => $message,
                    ]);
                }

                $total_ticket_quantity += $seats_count;
                $order_total += number_format($seats_count * $eventTicket->price,2);
                $booking_fee += number_format($seats_count * $eventTicket->booking_fee,2);
                $organiser_booking_fee += number_format($seats_count * $eventTicket->organiser_booking_fee,2);
                $tickets[] = [
                    'ticket' => $eventTicket->title,
                    'qty' => $seats_count,
                    'price' => number_format($eventTicket->price, 2),
                ];

                foreach ($seat_nos as $seat_no) {
                    $reservedTickets = new ReservedTickets();
                    $reservedTickets->ticket_id = $ticket_id;
                    $reservedTickets->event_id = $event_id;
                    $reservedTickets->quantity_reserved = 1;
                    $reservedTickets->expires = $order_expires_time;
                    $reservedTickets->session_id = $request->get('phone_id');
                    $reservedTickets->seat_no = $seat_no;
                    $reserved[] = $reservedTickets->attributesToArray();
                }

            }

            ReservedTickets::insert($reserved);

            $paymentMethods = Arr::only(config('payment'));

            return response()->json([
                'status' => 'success',
                'tickets'                 => $tickets,
                'order_started' => Carbon::now(),
                'expires' => env('CHECKOUT_TIMEOUT'),
                'order_total' => $order_total,
                'total_booking_fee' => $booking_fee + $organiser_booking_fee,
                'payment_methods' => $paymentMethods->pluck(['title', 'code'])->all()
            ]);
        }
        catch (\Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }


    /**
    * @OA\Schema(
    *     schema="OrderProcessRequest",
    *     title="Order Processing Request Model",
    *     @OA\Property(
    *        property="phone_id",
    *        type="integer"
    *     ),
    *     @OA\Property(
    *          property="name",
    *          type="string",
    *     ),
    *     @OA\Property(
    *          property="surname",
    *          type="string",
    *     ),
    *     @OA\Property(
    *          property="email",
    *          type="email",
    *     ),
     *     @OA\Property(
     *          property="payment_method",
     *          type="string",
     *     )
    * )
    * @OA\Post(
    *      path="/api/v2/event/{event_id}/register_order",
    *      operationId="Register order",
    *      tags={"Tickets"},
    *      summary="Register order",
    *      description="Register order",
    *      @OA\Parameter(
    *          description="Event ID",
    *          in="path",
    *          name="event_id",
    *          required=true,
    *          @OA\Schema(type="string"),
    *          @OA\Examples(example="int", value="1", summary="1"),
    *      ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/OrderProcessRequest")
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function postRegisterOrder(Request $request, $event_id){

        $gateway = new CardPayment();

        $validator = Validator::make($request->all(), [
                'phone_id'=>'required|min:8|max:45',
                'name'=>'required|string|min:2|max:255',
                'surname'=>'required|string|min:2|max:255',
                'email'=>'required|email',
                'payment_method'=>'required|in:'.implode(',',array_keys(config('payment')))
            ]);

        if($validator->fails()){
            return response()->json([
                'status'  => 'error',
                'message' => 'Please enter correctly',
            ]);
        }

        $phone_id = $request->get('phone_id');
        $holder_name = $request->get('name');
        $holder_surname = $request->get('surname');
        $holder_email = $request->get('email');

        Order::where('session_id', $request->get('phone_id'))
            ->where('order_status_id',5)
            ->delete();

        $event = Event::withReserved($phone_id)->with('organiser')
                        ->findOrFail($event_id,['id','organiser_fee_fixed','organiser_fee_percentage','organiser_id','account_id']);

        if(empty($event->reservedTickets) || $event->reservedTickets->count() == 0){
            return response()->json([
                'status'  => 'error',
                'message' => 'Session expired',
            ]);
        }

        $order_total = 0;
        $total_booking_fee = 0;
        $booking_fee = 0;
        $organiser_booking_fee = 0;


        foreach ($event->reservedTickets as $reserve){
            $order_total += $reserve->ticket->price;
            $booking_fee += $reserve->ticket->booking_fee;
            $obf = (int)ceil($reserve->ticket->price) === 0 ? 0 :
                round($reserve->ticket->price *($event->organiser_fee_percentage / 100) + $event->organiser_fee_fixed,2);
            $organiser_booking_fee += $obf;
            $total_booking_fee += $reserve->ticket->booking_fee + $obf;
        }

        $orderService = new OrderService($order_total, $total_booking_fee, $event);
        $orderService->calculateFinalCosts();

        $secondsToExpire = Carbon::now()->diffInSeconds($event->reservedTickets->first()->expires);

        $transaction_data = [
            'amount'      => $orderService->getGrandTotal()*100,
            'currency' => 934,
            'sessionTimeoutSecs' => $secondsToExpire,
            'description' => "Bilettm sargyt: {$holder_name} {$holder_surname}",
            'orderNumber'     => uniqid(),
            'failUrl'     => "https://bilettm.com/e/{$event_id}/checkout/finish_mobile?is_payment_cancelled=1",
            'returnUrl' => "https://bilettm.com/e/{$event_id}/checkout/finish_mobile?is_payment_successful=1",

        ];
        try{
            $response = $gateway->registerPayment($transaction_data);
            if($response->isSuccessfull()){
                $order = Order::create([
                    'first_name'            => $holder_name,
                    'last_name'             => $holder_surname,
                    'email'                 => $holder_email,
                    'order_status_id'       => 5,
                    'amount'                => $order_total,
                    'booking_fee'           => $booking_fee,
                    'organiser_booking_fee' => $organiser_booking_fee,
                    'discount'              => 0.00,
                    'account_id'            => $event->account_id,
                    'event_id'              => $event_id,
                    'is_payment_received'   => 0,
                    'taxamt'                => $orderService->getTaxAmount(),
                    'session_id'            => $phone_id,
                    'transaction_id'        => $response->getPaymentReferenceId(),
                    'order_date'            => Carbon::now(),
                    'order_reference'       => strtoupper(str_random(5)) . date('jn')
                ]);
                $order->save();
                $return = [
                    'status' => 'success',
                    'payment_url' => $response->getRedirectUrl()
                ];

            } else {
                $return = [
                    'status'  => 'error',
                    'message' => $response->errorMessage(),
                ];
            }


        }
        catch (\Exeption $e) {
            $return = [
                'status'  => 'error',
                'message' => 'Sorry, there was an error processing your payment. Please try again later.',
            ];

        }
        return response()->json($return);
    }

    public function postCompleteOrder(Request $request, $event_id,CardPayment $gateway){
        $orderId = $request->get('orderId');

        try{
            $response = $gateway->getPaymentStatus($orderId);

            if ($response->isSuccessfull()) {

                return $this->completeOrder($event_id,$request);
            } else {

                return response()->json([
                    'status'          => 'error',
                    'message' => $response->errorMessage(),
                ]);
            }
        }catch (\Exception $ex){
            return response()->json([
                'status'          => 'error',
                'message' => $ex->getMessage(),
            ]);
        }

    }
    

    /**
    * @OA\Schema(
    *     schema="TicketIds",
    *     title="TicketIds",
    *     @OA\Property(
    *        property="id",
    *        type="number"
    *     ),
    *     @OA\Property(
    *        property="seats",
    *        description="Seats",
    *        type="array",
    *        collectionFormat="multi",
    *        @OA\Items(type="string", format="id"),
    *        @OA\Examples(example="string", value="F-2", summary="F-2"),
    *     ),
    * )
    * @OA\Schema(
    *      schema="BookRequest",
    *      title="Title",
    *      @OA\Property(
    *           property="tickets",
    *           description="Tickets",
    *           type="array",
    *           collectionFormat="multi",
    *           @OA\Items(
    *               ref="#/components/schemas/TicketIds"
    *           ),
    *      ),
    *      @OA\Property(
    *            property="token",
    *            type="string"
    *      )
    * )
    * @OA\Post(
    *      path="/vendor/event/{event_id}/book",
    *      tags={"Operator"},
    *      summary="book event ticket i n opertaor app",
    *      description="book event ticket in opertaor app",
    *      @OA\Parameter(
    *          description="event_id",
    *          in="path",
    *          name="event_id",
    *          required=true,
    *          @OA\Schema(type="number"),
    *          @OA\Examples(example="number", value=2, summary="2"),
    *      ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/BookRequest")
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function offline_book(Request $request, $event_id){
        $event = Event::findOrfail($event_id,['id','account_id']);

        if(!$request->has('tickets')){
            return response()->json([
                'status'  => 'error',
                'message' => 'No tickets.'
            ]);
        }

        $tickets = $request->get('tickets');

        DB::beginTransaction();
        try{
            $order = Order::create([
                'first_name'            => 'kassa',
                'last_name'             => 'kassa',
                'email'                 => $request->auth->email,
                'order_status_id'       => 5,
                'discount'              => 0.00,
                'account_id'            => $event->account_id,
                'event_id'              => $event_id,
                'is_payment_received'   => 0,
                'order_date'            => Carbon::now(),
                'order_reference'       => strtoupper(str_random(5)) . date('jn')
            ]);

            foreach ($tickets as $ticket){
                $attendee_count = Attendee::where('ticket_id',$ticket['id'])
                    ->where('event_id',$event_id)
                    ->where('is_cancelled',false)
                    ->whereIn('seat_no', array_values($ticket['seats']))
                    ->count();

                if($attendee_count > 0){
                    DB::rollBack();
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Seats are already booked'
                    ]);
                }

                foreach ($ticket['seats'] as $key => $seat){
                    $attendee = new Attendee();
                    $attendee->first_name = $order->first_name;
                    $attendee->last_name = $order->last_name;
                    $attendee->email = $order->email;
                    $attendee->event_id = $event_id;
                    $attendee->order_id = $order->id;
                    $attendee->ticket_id = $ticket['id'];
                    $attendee->account_id = $event->account_id;
                    $attendee->reference_index = $key + 1;
                    $attendee->seat_no = $seat;
                    $attendee->save();
                }

            }
            DB::commit();
            return response()->json([
                'status'  => 'success',
                'message' => 'Reservation Completed',
            ]);
        }
        catch (\Exception $ex){
            Log::error($ex);
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => $ex->getMessage()
            ]);
        }

    }

    public function offline_cancel(Request $request,$event_id){
        if($request->has('ticket_id') && $request->has('seat_no')){
            $attendee = Attendee::where('event_id',$event_id)
                ->where('ticket_id',$request->get('ticket_id'))
                ->where('email',$request->auth->email)
                ->where('seat_no',$request->get('seat_no'))
                ->update(['is_cancelled' => true]);

            if($attendee)
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Reservation cancelled',
                ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Cancel unsuccessful'
        ]);

    }
}
