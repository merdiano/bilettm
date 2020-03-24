<?php

namespace App\Http\Controllers;

use App\Events\OrderCompletedEvent;
use App\Jobs\ProcessPayment;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\QuestionAnswer;
use App\Models\ReservedTickets;
use App\Models\Ticket;
use App\Payment\CardPayment;
use App\Services\EventOrderService as OrderService;
use Carbon\Carbon;
use Cookie;
use DB;
use Illuminate\Http\Request;
use Log;
use PDF;
use PhpSpec\Exception\Exception;
use Validator;

class EventCheckoutController extends Controller
{
    /**
     * Is the checkout in an embedded Iframe?
     *
     * @var bool
     */
    protected $is_embedded;
    /**
     * Payment gateway
     * @var CardPayment
     */
    protected $gateway;

    /**
     * EventCheckoutController constructor.
     * @param Request $request
     */
    public function __construct(Request $request, CardPayment $gateway)
    {
        /*
         * See if the checkout is being called from an embedded iframe.
         */
        $this->is_embedded = $request->get('is_embedded') == '1';
        $this->gateway = $gateway;
    }

    public function postValidateDate(Request $request, $event_id){

        $this->validate($request,['ticket_date'=>'required|date']);
        $event = Event::with('venue')->findOrFail($event_id);
        $tickets = Ticket::with(['section','reserved:seat_no,ticket_id','booked:seat_no,ticket_id'])
            ->where('event_id',$event_id)
            ->where('ticket_date',$request->get('ticket_date'))
            ->where('is_hidden', false)
            ->orderBy('sort_order','asc')
            ->get();

        if($tickets->count()==0){
            //todo flash message
            session()->flash('error','There is no tickets available');
            return redirect()->back();
        }

        return $this->render('Pages.SeatsPage',compact('event','tickets'));
    }
    /**
     * Validate a ticket request. If successful reserve the tickets and redirect to checkout
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postValidateSeats(Request $request, $event_id){
        if (!$request->has('seats')) {
            return response()->json([
                'status'  => 'error',
                'message' => trans('ClientSide.no_seats'),
            ]);
        }

        /*
         * Order expires after X min
         */
        $order_expires_time = Carbon::now()->addMinutes(config('attendize.checkout_timeout_after'));

        $event = Event::findOrFail($event_id);
        $seats = $request->get('seats');

        /*
         * Remove any tickets the user has reserved
         */
        ReservedTickets::where('session_id', '=', session()->getId())->delete();

        /*
         * Go though the selected tickets and check if they're available
         * , tot up the price and reserve them to prevent over selling.
         */
        $order_total = 0;
        $booking_fee = 0;
        $organiser_booking_fee = 0;
        $total_ticket_quantity = 0;
        $reserved = [];
        $tickets = [];
        $validation_rules = [];
        $validation_messages = [];
        foreach ($seats as $ticket_id=>$ticket_seats){
            $seats_count = count($ticket_seats);
            if(!$seats_count)
                continue;

            $seat_nos = array_values($ticket_seats);
            $reserved_tickets = ReservedTickets::where('ticket_id',$ticket_id)
                ->where('expires','>',Carbon::now())
                ->whereIn('seat_no',$seat_nos)
                ->pluck('seat_no');

            $booked_tickets = Attendee::where('ticket_id',$ticket_id)
                ->where('event_id',$event_id)
                ->whereIn('seat_no',$seat_nos)
                ->pluck('seat_no');

            if(count($reserved_tickets)>0 || count($booked_tickets)>0)
                return response()->json([
                    'status'   => 'error',
                    'message' => trans('ClientSide.message_reserved'),//todo show which are reserved
                ]);

            $ticket = Ticket::findOrFail($ticket_id);
            $max_per_person = min($ticket->quantity_remaining, $ticket->max_per_person);
            /*
             * Validation max min ticket count
             */
            if($seats_count < $ticket->min_per_person){
                $message = trans('ClientSide.min_ticket_message',['min' => $ticket->min_per_person]);
            }elseif ($seats_count > $max_per_person){
                $message = trans('ClientSide.max_ticket_message',['max' => $ticket->quantity_remaining]);
            }

            if (isset($message)) {
                return response()->json([
                    'status'   => 'error',
                    'messages' => $message,
                ]);
            }

            $total_ticket_quantity += $seats_count;
            $order_total += ($seats_count * $ticket->price);
            $booking_fee += ($seats_count * $ticket->booking_fee);
            $organiser_booking_fee += ($seats_count * $ticket->organiser_booking_fee);
            $tickets[] = [
                'ticket'                => $ticket,
                'qty'                   => $seats_count,
                'seats'                 => $ticket_seats,
                'price'                 => ($seats_count * $ticket->price),
                'booking_fee'           => ($seats_count * $ticket->booking_fee),//total_service_booking_fee per ticket
                'organiser_booking_fee' => ($seats_count * $ticket->organiser_booking_fee),//total_organiser_booking_fee per ticket
                'total_booking_fee'     => $ticket->total_booking_fee,//service + organiser original booking fee sum
                'original_price'        => $ticket->price,
            ];


            foreach ($ticket_seats as $seat_no){
                $reservedTickets = new ReservedTickets();
                $reservedTickets->ticket_id = $ticket_id;
                $reservedTickets->event_id = $event_id;
                $reservedTickets->quantity_reserved = 1;
                $reservedTickets->expires = $order_expires_time;
                $reservedTickets->session_id = session()->getId();
                $reservedTickets->seat_no = $seat_no;
                $reserved[] = $reservedTickets->attributesToArray();
                /*
                 * Create our validation rules here
                 */
                $validation_rules['ticket_holder_first_name.' . $seat_no . '.' . $ticket_id] = ['required'];
                $validation_rules['ticket_holder_last_name.' . $seat_no . '.' . $ticket_id] = ['required'];
                $validation_rules['ticket_holder_email.' . $seat_no . '.' . $ticket_id] = ['required', 'email'];

                $validation_messages['ticket_holder_first_name.' . $seat_no . '.' . $ticket_id . '.required'] = trans('ClientSide.holder_first_name_required',['seat' => $seat_no]);
                $validation_messages['ticket_holder_last_name.' . $seat_no . '.' . $ticket_id . '.required'] = trans('ClientSide.holder_last_name_required',['seat' => $seat_no]);
                $validation_messages['ticket_holder_email.' . $seat_no . '.' . $ticket_id . '.required'] = trans('ClientSide.holder_email_required',['seat' => $seat_no]);;
                $validation_messages['ticket_holder_email.' . $seat_no . '.' . $ticket_id . '.email'] = trans('ClientSide.holder_email_invalid',['seat' => $seat_no]);;
                /*
                 * Validation rules for custom questions
                 */
                foreach ($ticket->questions as $question) {
                    if ($question->is_required && $question->is_enabled) {
                        $validation_rules['ticket_holder_questions.' . $ticket_id . '.' . $seat_no . '.' . $question->id] = ['required'];
                        $validation_messages['ticket_holder_questions.' . $ticket_id . '.' . $seat_no . '.' . $question->id . '.required'] = trans('ClientSide.question_required');
                    }
                }
            }
        }
        ReservedTickets::insert($reserved);

        if (empty($tickets)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No tickets selected.',
            ]);
        }
        /*
         * The 'ticket_order_{event_id}' session stores everything we need to complete the transaction.
         */
        session()->put('ticket_order_' . $event->id, [
            'validation_rules'        => $validation_rules,
            'validation_messages'     => $validation_messages,
            'event_id'                => $event->id,
            'tickets'                 => $tickets,
            'total_ticket_quantity'   => $total_ticket_quantity,
            'order_started'           => time(),
            'expires'                 => $order_expires_time,
            'order_total'             => $order_total,
            'booking_fee'             => $booking_fee,
            'organiser_booking_fee'   => $organiser_booking_fee,
            'total_booking_fee'       => $booking_fee + $organiser_booking_fee,
            'order_requires_payment'  => (ceil($order_total) == 0) ? false : true,
            'account_id'              => $event->account->id,
        ]);

        /*
         * If we're this far assume everything is OK and redirect them
         * to the the checkout page.
         */
        if ($request->ajax()) {
            return response()->json([
                'status'      => 'success',
                'redirectUrl' => route('showEventCheckout', [
                        'event_id'    => $event_id,
                        'is_embedded' => $this->is_embedded,
                    ]) . '#order_form',
            ]);
        }

        /*
         * todo Maybe display something prettier than this?
         */
        exit(trans('ClientSide.enable_javascript'));
    }

    /**
     * Show the checkout page
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showEventCheckout(Request $request, $event_id)
    {
        $order_session = session()->get('ticket_order_' . $event_id);

        if (!$order_session || $order_session['expires'] < Carbon::now()) {
            $route_name = $this->is_embedded ? 'showEmbeddedEventPage' : 'showEventPage';
            return redirect()->route($route_name, ['event_id' => $event_id]);
        }

        $secondsToExpire = Carbon::now()->diffInSeconds($order_session['expires']);

        $event = Event::with('venue')->findorFail($order_session['event_id']);

        $orderService = new OrderService($order_session['order_total'], $order_session['total_booking_fee'], $event);
        $orderService->calculateFinalCosts();

        $data = $order_session + [
                'event'           => $event,
                'secondsToExpire' => $secondsToExpire,
                'is_embedded'     => $this->is_embedded,
                'orderService'    => $orderService
                ];

        if ($this->is_embedded) {
            return view('Public.ViewEvent.Embedded.EventPageCheckout', $data); // <--- todo check this out
        }

        return $this->render('Pages.CheckoutPage', $data);
    }

    /**
     * Create the order, handle payment, update stats, fire off email jobs then redirect user
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateOrder(Request $request, $event_id)
    {
        //If there's no session kill the request and redirect back to the event homepage.
        $order_session = session()->get('ticket_order_' . $event_id);
        if (!$order_session) {
            return response()->json([
                'status'      => 'error',
                'message'     => 'Your session has expired.',
                'redirectUrl' => route('showEventPage', [
                    'event_id' => $event_id,
                ])
            ]);
        }

        $event = Event::findOrFail($event_id);
        $order = new Order();
        $ticket_order = session()->get('ticket_order_' . $event_id);

        $validation_rules = $ticket_order['validation_rules'];
        $validation_messages = $ticket_order['validation_messages'];

        $order->rules = $order->rules + $validation_rules;
        $order->messages = $order->messages + $validation_messages;

        if (!$order->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $order->errors(),
            ]);
        }

        //Add the request data to a session in case payment is required off-site
        session()->push('ticket_order_' . $event_id . '.request_data', $request->except(['card-number', 'card-cvc']));

        $orderRequiresPayment = $ticket_order['order_requires_payment'];

        if ($orderRequiresPayment && $request->get('pay_offline') && $event->enable_offline_payments) {
            return $this->completeOrder($event_id);
        }

        if (!$orderRequiresPayment) {
            return $this->completeOrder($event_id);
        }

        try {
            $orderService = new OrderService($ticket_order['order_total'], $ticket_order['total_booking_fee'], $event);
            $orderService->calculateFinalCosts();
            $secondsToExpire = Carbon::now()->diffInSeconds($order_session['expires']);
            $transaction_data =[
                'amount'      => $orderService->getGrandTotal()*100,//multiply by 100 to obtain tenge
                'currency' => 934,
                'sessionTimeoutSecs' => $secondsToExpire,
                'description' => 'bilettm sargyt: ' . $request->get('order_email'),
                'orderNumber'     => uniqid(),

                'failUrl'     => route('showEventCheckoutPaymentReturn', [
                    'event_id'             => $event_id,
                    'is_payment_cancelled' => 1
                ]),
                'returnUrl' => route('showEventCheckoutPaymentReturn', [
                    'event_id'              => $event_id,
                    'is_payment_successful' => 1
                ]),

            ];

            $response = $this->gateway->registerPayment($transaction_data);

            if($response->isSuccessfull()){

                $order->first_name = $request->get('order_first_name');
                $order->last_name = $request->get('order_last_name');
                $order->email = $request->get('order_email');
                $order->order_status_id = 5;//order awaiting payment
                $order->amount = $orderService->getGrandTotal();
                $order->booking_fee = $ticket_order['booking_fee'];
                $order->organiser_booking_fee = $ticket_order['organiser_booking_fee'];
                $order->discount = 0.00;
                $order->account_id = $event->account_id;
                $order->event_id = $event_id;
                $order->is_payment_received = 0;//false
                $order->taxamt = $orderService->getTaxAmount();
                $order->session_id = session()->getId();
                $order->transaction_id = $response->getPaymentReferenceId();
                $order->order_date = Carbon::now();
                $order->save();

                session()->push('ticket_order_' . $event_id . '.order_id', $order->id);
                Log::info("Redirect url: " . $response->getRedirectUrl());

                $return = [
                    'status'       => 'success',
                    'redirectUrl'  => $response->getRedirectUrl(),
                    'message'      => 'Redirecting to payment gateway'
                ];

                return response()->json($return);

            } else {
                // display error to customer
                return response()->json([
                    'status'  => 'error',
                    'message' => $response->errorMessage(),
                ]);
            }
        } catch (\Exeption $e) {
            Log::error($e);
            $error = trans('ClientSide.payment_error');
        }

        if ($error) {
            return response()->json([
                'status'  => 'error',
                'message' => $error,
            ]);
        }

    }

    /**
     * Attempt to complete a user's payment when they return from
     * an off-site gateway
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function showEventCheckoutPaymentReturn(Request $request, $event_id)
    {
        if ($request->get('is_payment_cancelled') == '1') {
            session()->flash('message', trans('Event.payment_cancelled'));
            return response()->redirectToRoute('showEventCheckout', [
                'event_id'             => $event_id,
                'is_payment_cancelled' => 1,
            ]);
        }

        $order_id = session()->get('ticket_order_' . $event_id . '.order_id');
        $ticket_order = session()->get('ticket_order_' . $event_id);
        $order = Order::findOrFail(sanitise($order_id[0]));
        foreach ($ticket_order['tickets'] as $attendee_details) {
            /*
             * Insert order items (for use in generating invoices)
             */
            $unit_booking_fee = $attendee_details['ticket']['booking_fee'] + $attendee_details['ticket']['organiser_booking_fee'];

            OrderItem::create([
                'title' => $attendee_details['ticket']['title'],
                'order_id' => $order->id,
                'quantity' => $attendee_details['qty'],
                'unit_price' => $attendee_details['ticket']['price'],
                'unit_booking_fee' => $unit_booking_fee
            ]);
        }


        $response = $this->gateway->getPaymentStatus($order->transaction_id);

        //todo try catch for connection errors
        if ($response->isSuccessfull()) {

            OrderService::completeOrder($ticket_order, $order);
            return response()->redirectToRoute('showOrderDetails', [
                'is_embedded'     => $this->is_embedded,
                'order_reference' => $order->order_reference,
            ]);
        } else {
            //some times bank responds as payment not processed and we check 5 minutes later paymant status
            ProcessPayment::dispatch($order,$ticket_order)->delay(now()->addMinutes(5));
            return $this->render('Pages.OrderExpectingPayment');
        }
    }

    public function mobileCheckoutPaymentReturn(Request $request, $event_id){
        if ($request->get('is_payment_cancelled') == '1') {
            return view('mobile.CheckoutFailed',['message'=>trans('ClientSide.payment_cancelled')]);
        }
        else if(!$request->has('orderId')){
            return view('mobile.CheckoutFailed',['message'=> trans('ClientSide.no_order_id')]);
        }

        $order = Order::select('orders.id','order_status_id','is_payment_received','amount','booking_fee','created_at',
            'organiser_booking_fee','event_id','session_id','account_id','first_name','last_name','email','order_reference')
            ->with(['event:id,sales_volume,organiser_fees_volume,organiser_id,title,post_order_display_message'])
            ->where('event_id',$event_id)
            ->where('transaction_id',$request->get('orderId'))
            ->first();

        if(!$order){
            return view('mobile.CheckoutFailed',['message'=> trans('ClientSide.order_error')]);
        }

        $reserved_tickets = ReservedTickets::select('ticket_id',DB::raw('count(*) as quantity'))
            ->groupBy('ticket_id')
            ->with(['ticket:id,price,title'])
            ->where('session_id', $order->session_id)
            ->where('event_id', $event_id)
            ->get();
        /*
         * Insert order items (for use in generating invoices)
         */
        foreach ($reserved_tickets as $resTicket){
            $orderItem = new OrderItem();
            $orderItem->title = $resTicket->ticket->title;
            $orderItem->quantity = $resTicket->quantity;
            $orderItem->order_id = $order->id;
            $orderItem->unit_price = $resTicket->ticket->price;
            $orderItem->unit_booking_fee = $resTicket->ticket->booking_fee + $order->organiser_booking_fee;
            $orderItem->save();
        }

        $response = $this->gateway->getPaymentStatus($request->get('orderId'));

        if ($response->isSuccessfull()) {
            $data = OrderService::mobileCompleteOrder($order);
            return view('mobile.CheckoutSuccess', $data);
        } else {
            ProcessPayment::dispatch($order)->delay(now()->addMinutes(5));
            return $this->render('Pages.OrderExpectingPayment');
        }
    }
    /**
     * Complete an order
     *
     * @param $event_id
     * @param bool|true $return_json
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function completeOrder($event_id, $return_json = true)
    {

        DB::beginTransaction();

        try {

            $order = Order::with('event')
                ->where('event_id', $event_id)
                ->where('session_id', session()->getId());
            $ticket_order = session()->get('ticket_order_' . $event_id);
            $request_data = $ticket_order['request_data'][0];
//            $event = Event::findOrFail($ticket_order['event_id']);
            $attendee_increment = 1;
            $ticket_questions = isset($request_data['ticket_holder_questions']) ? $request_data['ticket_holder_questions'] : [];
            $order->order_status_id = isset($request_data['pay_offline']) ? config('attendize.order_awaiting_payment') : config('attendize.order_complete');
            $order->is_payment_received = isset($request_data['pay_offline']) ? 0 : 1;
            $order->save();

            /*
             * Update the event sales volume
             */
            $order->event->increment('sales_volume', $order->amount);
            $order->event->increment('organiser_fees_volume', $order->organiser_booking_fee);

            /*
             * Update the event stats
             */
            $event_stats = EventStats::updateOrCreate([
                'event_id' => $event_id,
                'date'     => DB::raw('CURRENT_DATE'),
            ]);
            $event_stats->increment('tickets_sold', $ticket_order['total_ticket_quantity']);

            if ($ticket_order['order_requires_payment']) {
                $event_stats->increment('sales_volume', $order->amount);
                $event_stats->increment('organiser_fees_volume', $order->organiser_booking_fee);
            }

            /*
             * Add the attendees
             */
            foreach ($ticket_order['tickets'] as $attendee_details) {

                $ticket = Ticket::findOrFail($attendee_details['ticket']['id']);

                /*
                 * Update some ticket info
                 */
                $ticket->increment('quantity_sold', $attendee_details['qty']);
                $ticket->increment('sales_volume', ($attendee_details['ticket']['price'] * $attendee_details['qty']));
                $ticket->increment('organiser_fees_volume',
                    ($attendee_details['ticket']['organiser_booking_fee'] * $attendee_details['qty']));

                /*
                 * Create the attendees
                 */
                foreach ($attendee_details['seats'] as $i) {

                    $attendee = new Attendee();
                    $attendee->first_name = strip_tags($request_data["ticket_holder_first_name"][$i][$attendee_details['ticket']['id']]);
                    $attendee->last_name = strip_tags($request_data["ticket_holder_last_name"][$i][$attendee_details['ticket']['id']]);
                    $attendee->email = $request_data["ticket_holder_email"][$i][$attendee_details['ticket']['id']];
                    $attendee->event_id = $event_id;
                    $attendee->order_id = $order->id;
                    $attendee->ticket_id = $attendee_details['ticket']['id'];
                    $attendee->account_id = $order->account_id;
                    $attendee->reference_index = $attendee_increment;
                    $attendee->seat_no = $i;
                    $attendee->save();


                    /*
                     * Save the attendee's questions
                     */
                    foreach ($attendee_details['ticket']->questions as $question) {


                        $ticket_answer = isset($ticket_questions[$attendee_details['ticket']->id][$i][$question->id]) ? $ticket_questions[$attendee_details['ticket']->id][$i][$question->id] : null;

                        if (is_null($ticket_answer)) {
                            continue;
                        }

                        /*
                         * If there are multiple answers to a question then join them with a comma
                         * and treat them as a single answer.
                         */
                        $ticket_answer = is_array($ticket_answer) ? implode(', ', $ticket_answer) : $ticket_answer;

                        if (!empty($ticket_answer)) {
                            QuestionAnswer::create([
                                'answer_text' => $ticket_answer,
                                'attendee_id' => $attendee->id,
                                'event_id'    => $event_id,
                                'account_id'  => $order->account_id,
                                'question_id' => $question->id
                            ]);

                        }
                    }


                    /* Keep track of total number of attendees */
                    $attendee_increment++;
                }
            }

        } catch (Exception $e) {

            Log::error($e);
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => trans('ClientSide.order_error')
            ]);

        }
        //save the order to the database
        DB::commit();
        //forget the order in the session
        session()->forget('ticket_order_' . $event_id);

        /*
         * Remove any tickets the user has reserved after they have been ordered for the user
         */
        ReservedTickets::where('session_id', '=', session()->getId())->delete();

        // Queue up some tasks - Emails to be sent, PDFs etc.
        Log::info('Firing the event');
        event(new OrderCompletedEvent($order));


        if ($return_json) {
            return response()->json([
                'status'      => 'success',
                'redirectUrl' => route('showOrderDetails', [
                    'is_embedded'     => $this->is_embedded,
                    'order_reference' => $order->order_reference,
                ]),
            ]);
        }

        return response()->redirectToRoute('showOrderDetails', [
            'is_embedded'     => $this->is_embedded,
            'order_reference' => $order->order_reference,
        ]);

    }

    /**
     * Show the order details page
     *
     * @param Request $request
     * @param $order_reference
     * @return \Illuminate\View\View
     */
    public function showOrderDetails(Request $request, $order_reference)
    {
        $order = Order::where('order_reference', '=', $order_reference)->first();

        if (!$order) {
            abort(404);
        }

        $orderService = new OrderService($order->amount, $order->booking_fee+$order->organiser_booking_fee, $order->event);
        $orderService->calculateFinalCosts();

        $data = [
            'order'        => $order,
            'orderService' => $orderService,
            'event'        => $order->event,
            'tickets'      => $order->event->tickets,
            'is_embedded'  => $this->is_embedded,
        ];

        if ($this->is_embedded) {
            return view('Public.ViewEvent.Embedded.EventPageViewOrder', $data);
        }

        return view('desktop.Pages.ViewOrderPage', $data);
//        return view('Public.ViewEvent.EventPageViewOrder', $data);
    }

    /**
     * Shows the tickets for an order - either HTML or PDF
     *
     * @param Request $request
     * @param $order_reference
     * @return \Illuminate\View\View
     */
    public function showOrderTickets(Request $request, $order_reference)
    {
        $order = Order::where('order_reference', '=', $order_reference)->first();

        if (!$order) {
            abort(404);
        }
        $images = [];
        $imgs = $order->event->images;
        foreach ($imgs as $img) {
            $images[] = base64_encode(file_get_contents(public_path($img->image_path)));
        }

        $data = [
            'order'     => $order,
            'event'     => $order->event,
            'tickets'   => $order->event->tickets,
            'attendees' => $order->attendees,
            'css'       => file_get_contents(public_path('assets/stylesheet/ticket.css')),
            'image'     => base64_encode(file_get_contents(public_path($order->event->organiser->full_logo_path))),
            'images'    => $images,
        ];

        if ($request->get('download') == '1') {
            return PDF::html('Public.ViewEvent.Partials.PDFTicket', $data, 'Tickets');
        }
        return view('Public.ViewEvent.Partials.PDFTicket', $data);
    }
}

