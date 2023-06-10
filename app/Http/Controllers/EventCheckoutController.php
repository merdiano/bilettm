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
use Agent;
use App\Jobs\SendOrderTickets;


class EventCheckoutController extends Controller
{

    public function postValidateDate(Request $request, $event_id)
    {
        $this->validate($request,['ticket_date'=>'required|date']);

        $event = Event::with('venue')->findOrFail($event_id);

        $ticket_date = $request->get('ticket_date');

        $tickets = Ticket::with(['section','reserved:seat_no,ticket_id','booked:seat_no,ticket_id'])
            ->where('event_id',$event_id)
            ->where('ticket_date',$ticket_date)
            ->where('is_hidden', false)
            ->orderBy('sort_order','asc')
            ->get();

        if($tickets->count()==0){
            //todo flash message
            session()->flash('error','There is no tickets available');
            return redirect()->back();
        }

        $venue = $event->venue;
        $ticket_date = Carbon::parse($ticket_date)->format('d.m.Y');
        return $this->render('Pages.SeatsPage',compact('event','tickets', 'ticket_date','venue'));
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
        ReservedTickets::where('session_id', '=', session()->getId())
            ->whereNull('expects_payment_at')
            ->orWhere('expects_payment_at','<',Carbon::now()->addMinutes(-5))
            ->delete();

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
                ->where('is_cancelled',false)
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
//                $validation_rules['ticket_holder_first_name.' . $seat_no . '.' . $ticket_id] = ['required'];
//                $validation_rules['ticket_holder_last_name.' . $seat_no . '.' . $ticket_id] = ['required'];
//                $validation_rules['ticket_holder_email.' . $seat_no . '.' . $ticket_id] = ['required', 'email'];
//
//                $validation_messages['ticket_holder_first_name.' . $seat_no . '.' . $ticket_id . '.required'] = trans('ClientSide.holder_first_name_required',['seat' => $seat_no]);
//                $validation_messages['ticket_holder_last_name.' . $seat_no . '.' . $ticket_id . '.required'] = trans('ClientSide.holder_last_name_required',['seat' => $seat_no]);
//                $validation_messages['ticket_holder_email.' . $seat_no . '.' . $ticket_id . '.required'] = trans('ClientSide.holder_email_required',['seat' => $seat_no]);;
//                $validation_messages['ticket_holder_email.' . $seat_no . '.' . $ticket_id . '.email'] = trans('ClientSide.holder_email_invalid',['seat' => $seat_no]);;
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
                        'is_embedded' => false,
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

            return redirect()->route('showEventPage', ['event_id' => $event_id]);
        }

        $secondsToExpire = Carbon::now()->diffInSeconds($order_session['expires']);

        $event = Event::with('venue')->findorFail($order_session['event_id']);

        $orderService = new OrderService($order_session['order_total'], $order_session['total_booking_fee'], $event);
        $orderService->calculateFinalCosts();

        $data = $order_session + [
                'event'           => $event,
                'secondsToExpire' => $secondsToExpire,
                'orderService'    => $orderService
                ];

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

        $validation_rules = $order_session['validation_rules'];
        $validation_messages = $order_session['validation_messages'];

        $paymentMethods = implode(',',array_keys(config('payment')));

        $validation_rules['payment'] = ['required','in:'.$paymentMethods];
        $validation_messages['payment.required'] = trans('ClientSide.payment.required');
        $validation_messages['payment.in'] = "Payment methods must be within: ".$paymentMethods;

        $order = new Order();
        $order->rules = $order->rules + $validation_rules;
        $order->messages = $order->messages + $validation_messages;
        $order->order_reference = strtoupper(str_random(5)) . date('jn');

        if (!$order->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $order->errors(),
            ]);
        }

        //Add the request data to a session in case payment is required off-site
        session()->push('ticket_order_' . $event_id . '.request_data', $request->except(['card-number', 'card-cvc']));
        $event = Event::findOrFail($event_id);

        try {
            $orderService = new OrderService($order_session['order_total'], $order_session['total_booking_fee'], $event);
            $orderService->calculateFinalCosts();

            $paymentMethod = $request->get('payment');

            $gatewayClass = config('payment.'.$paymentMethod.'.class');
            $gateway = new $gatewayClass();

            $secondsToExpire = Carbon::now()->diffInSeconds($order_session['expires']);

            $response = $gateway->registerPaymentOrder($order->order_reference,
                $orderService->getGrandTotal(),
                $event_id,
                $secondsToExpire
            );

            if($response->isSuccessfull()){
                $order->transaction_id = $response->getReferenceId();
                $order_id = $orderService->saveOrder($order);
                session()->put('ticket_order_' . $event_id . '.order_id', $order_id);
                session()->put('ticket_order_' . $event_id . '.payment_method', $paymentMethod);

                $return = [
                    'status'       => 'success',
                    'redirectUrl'  => $response->getRedirectUrl(),
                    'message'      => trans('ClientSide.redirect_payment_message')
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
        if(!Agent::isDesktop()){
            return $this->mobileCheckoutPaymentReturn($request, $event_id);
        }

        if ($request->has('fail')) {
            session()->flash('message', trans('Event.payment_cancelled'));
            return response()->redirectToRoute('showEventCheckout', [
                'event_id'             => $event_id,
                'is_payment_cancelled' => 1,
            ]);
        }

        $order_id = session()->get('ticket_order_' . $event_id . '.order_id');
        $order = Order::findOrFail(sanitise($order_id));

        //if page is refreshed and order is already registered successfully
        if($order->order_status_id == 1){
            return response()->redirectToRoute('showOrderDetails', [
                'is_embedded'     => false,
                'order_reference' => $order->order_reference,
            ]);
        }
        $ticket_order = session()->get('ticket_order_' . $event_id);

        $method = sanitise($ticket_order['payment_method']);
        $gatewayClass = config('payment.'.$method.'.class');
        $gateway = new $gatewayClass();

        try {
            $response = $gateway->getPaymentStatus($order->transaction_id);
            if ($response->isSuccessfull()) {

                $order->fill($response->getPaymentInfo());

                OrderService::completeOrder($ticket_order, $order);
                return response()->redirectToRoute('showOrderDetails', [
                    'is_embedded'     => false,
                    'order_reference' => $order->order_reference,
                ]);
            } else {
                //some times bank responds as payment not processed and we check 5 minutes later paymant status
//            ProcessPayment::dispatch($order,$ticket_order)->delay(now()->addMinutes(5));
                return $this->render('Pages.OrderExpectingPayment');
            }
        }catch (\Exeption $e) {
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

    public function mobileCheckoutPaymentReturn(Request $request, $event_id){
        if ($request->has('fail')) {
            return view('mobile.Pages.CheckoutFailed',['message'=>trans('ClientSide.payment_cancelled')]);
        }
        else if(!$request->has('orderId') || !$request->has('method')){
            return view('mobile.Pages.CheckoutFailed',['message'=> trans('ClientSide.no_order_id')]);
        }

        $order = Order::select('orders.id','order_status_id','is_payment_received','amount','booking_fee','created_at',
            'organiser_booking_fee','event_id','session_id','account_id','first_name','last_name','email','order_reference')
            ->with(['event:id,sales_volume,organiser_fees_volume,organiser_id,title,post_order_display_message'])
            ->where('event_id',$event_id)
            ->where('transaction_id',$request->get('orderId'))
            ->first();

        if(!$order){
            return view('mobile.Pages.CheckoutFailed',['message'=> trans('ClientSide.order_error')]);
        }


        /*
         * Insert order items (for use in generating invoices)
         */
        try {
            $paymentMethod = $request->get('method');

            $gatewayClass = config('payment.'.$paymentMethod.'.class');
            $gateway = new $gatewayClass();


            $response = $gateway->getPaymentStatus($order->transaction_id);

            if ($response->isSuccessfull()) {

                $order->fill($response->getPaymentInfo());

                $data = OrderService::mobileCompleteOrder($order);
                return view('mobile.Pages.ViewOrderPageApp', $data);
            } else {
                ReservedTickets::where('session_id', $order->session_id)
                    ->where('event_id', $event_id)
                    ->update(['expects_payment_at' => Carbon::now()]);
                ProcessPayment::dispatch($order)->delay(now()->addMinutes(5));
                return $this->render('Pages.OrderExpectingPayment',$order);
            }

        }catch (\Exception $e){
            Log::error($e);
            $error = trans('ClientSide.payment_error');
            return view('mobile.Pages.CheckoutFailed',['message'=> $error]);
        }
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
        SendOrderTickets::dispatch($order);

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

        ];

        return $this->render('Pages.ViewOrderPage', $data);
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
        //dd($data);

        if ($request->get('download') == '1') {
            $pdf = PDF::loadView('Public.ViewEvent.Partials.PDFTicket', $data);
            return $pdf->download(uniqid('ticket_') . '.pdf');
        }
        return view('Public.ViewEvent.Partials.PDFTicket', $data);
    }
}

