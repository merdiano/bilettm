<?php

namespace App\Services;
use PhpSpec\Exception\Exception;
use App\Events\OrderCompletedEvent;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Ticket;
use App\Models\Attendee;
use App\Models\ReservedTickets;
use App\Models\QuestionAnswer;
use DB;
use Log;
class EventOrderService
{

    /**
     * @var float
     */
    private $orderTotal;

    /**
     * @var float
     */
    private $totalBookingFee;

    /**
     * @var Event
     */
    private $event;

    /**
     * @var float
     */
    public $orderTotalWithBookingFee;

    /**
     * @var float
     */
    public $taxAmount;

    /**
     * @var float
     */
    public $grandTotal;

    /**
     * Order constructor.
     * @param $orderTotal
     * @param $totalBookingFee
     * @param $event
     */
    public function __construct($orderTotal, $totalBookingFee, $event) {

        $this->orderTotal = $orderTotal;
        $this->totalBookingFee = $totalBookingFee;
        $this->event = $event;
    }


    /**
     * Calculates the final costs for an event and sets the various totals
     */
    public function calculateFinalCosts()
    {
        $this->orderTotalWithBookingFee = $this->orderTotal + $this->totalBookingFee;

        if ($this->event->organiser->charge_tax == 1) {
            $this->taxAmount = ($this->orderTotalWithBookingFee * $this->event->organiser->tax_value)/100;
        } else {
            $this->taxAmount = 0;
        }

        $this->grandTotal = $this->orderTotalWithBookingFee + $this->taxAmount;
    }

    /**
     * @param bool $currencyFormatted
     * @return float|string
     */
    public function getOrderTotalWithBookingFee($currencyFormatted = false) {

        if ($currencyFormatted == false ) {
            return number_format($this->orderTotalWithBookingFee, 2, '.', '');
        }

        return money($this->orderTotalWithBookingFee, $this->event->currency);
    }

    /**
     * @param bool $currencyFormatted
     * @return float|string
     */
    public function getTaxAmount($currencyFormatted = false) {

        if ($currencyFormatted == false ) {
            return number_format($this->taxAmount, 2, '.', '');
        }

        return money($this->taxAmount, $this->event->currency);
    }

    /**
     * @param bool $currencyFormatted
     * @return float|string
     */
    public function getGrandTotal($currencyFormatted = false) {

        if ($currencyFormatted == false ) {
            return number_format($this->grandTotal, 2, '.', '');
        }

        return money($this->grandTotal, $this->event->currency);

    }

    /**
     * @return string
     */
    public function getVatFormattedInBrackets() {
        return "(+" . $this->getTaxAmount(true) . " " . $this->event->organiser->tax_name . ")";
    }

    public static function completeOrder($session_data,$order){
        DB::beginTransaction();

        try {
            $request_data = $session_data['request_data'][0];
            $event = Event::findOrFail($order->id);
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
                'event_id' => $event->id,
                'date'     => DB::raw('CURRENT_DATE'),
            ]);
            $event_stats->increment('tickets_sold', $session_data['total_ticket_quantity']);

            if ($session_data['order_requires_payment']) {
                $event_stats->increment('sales_volume', $order->amount);
                $event_stats->increment('organiser_fees_volume', $order->organiser_booking_fee);
            }

            /*
             * Add the attendees
             */
            foreach ($session_data['tickets'] as $attendee_details) {

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
                    $attendee->event_id = $event->id;
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
                                'event_id'    => $event->id,
                                'account_id'  => $order->account_id,
                                'question_id' => $question->id
                            ]);

                        }
                    }


                    /* Keep track of total number of attendees */
                    $attendee_increment++;
                }
            }
            /*
              * Remove any tickets the user has reserved after they have been ordered for the user
              */
            ReservedTickets::where('session_id', '=', $order->session_id)->delete();

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
//        session()->forget('ticket_order_' . $event->id);

        // Queue up some tasks - Emails to be sent, PDFs etc.
        Log::info('Firing the event');
        event(new OrderCompletedEvent($order));

        return $order->order_reference;

    }

    public static function mobileCompleteOrder($event_id,$transaction_id){
        DB::beginTransaction();

        try {

            $order = Order::select('orders.id','order_status_id','is_payment_received','amount','booking_fee','created_at',
                'organiser_booking_fee','event_id','session_id','account_id','first_name','last_name','email','order_reference')
                ->with(['event:id,sales_volume,organiser_fees_volume,organiser_id,title,post_order_display_message'])
                ->where('transaction_id',$transaction_id)
                ->where('event_id',$event_id)
                ->first();

            $order->order_status_id = config('attendize.order_complete');
            $order->is_payment_received = true;
            $obf = $order->organiser_booking_fee;
//            $orderService = new OrderService($order->amount, $order->booking_fee + $obf, $order->event);
//            $orderService->calculateFinalCosts();
            /*
             * Update the event sales volume
             */
            $event = $order->event;
//            $event->increment('sales_volume', $orderService->getGrandTotal());
            $event->increment('organiser_fees_volume', $obf);

            $reserved_tickets = ReservedTickets::select('id', 'seat_no', 'ticket_id')
                ->with(['ticket:id,quantity_sold,sales_volume,organiser_fees_volume,price'])
                ->where('session_id', $order->session_id)
                ->where('event_id', $event_id)
                ->get();
            /*
             * Update the event stats
             */
            $event_stats = EventStats::updateOrCreate([
                'event_id' => $event_id,
                'date' => DB::raw('CURRENT_DATE'),
            ]);

            $event_stats->increment('tickets_sold', $reserved_tickets->count() ?? 0);
            $event_stats->increment('sales_volume', $order->amount);
            $event_stats->increment('organiser_fees_volume', $obf);
            $attendee_increment = 1;
            /*
             * Add the attendees
             */

            foreach ($reserved_tickets as $reserved) {

                $ticket = $reserved->ticket;

                /*
                 * Update some ticket info
                 */
                $ticket->increment('quantity_sold', 1);
                $ticket->increment('sales_volume', $ticket->price);
                $ticket->increment('organiser_fees_volume', $obf);// * $reserved->quantity_reserved

                /*
                 * Create the attendees
                 */
                $attendee = new Attendee();
                $attendee->first_name = $order->first_name;
                $attendee->last_name = $order->last_name;
                $attendee->email = $order->email;
                $attendee->event_id = $order->event_id;
                $attendee->order_id = $order->id;
                $attendee->ticket_id = $reserved->ticket_id;
                $attendee->account_id = $order->account_id;
                $attendee->reference_index = $attendee_increment;
                $attendee->seat_no = $reserved->seat_no;
                $attendee->save();

                /* Keep track of total number of attendees */
                $attendee_increment++;
            }

            $order->save();
            DB::commit();
        }
        catch (\Exception $ex){

            Log::error($ex);
            DB::rollBack();

            return ['message' => $ex->getMessage()];
        }

        /*
         * Remove any tickets the user has reserved after they have been ordered for the user
         */
        ReservedTickets::where('session_id', $order->session_id)->delete();

        Log::info('Firing the event');
        event(new OrderCompletedEvent($order));
        return [
            'order'        => $order,
            'orderService' => $orderService,
            'event'        => $order->event,
            'tickets'      => $order->event->tickets,
        ];
        //return view('mobile.CheckoutSuccess', $data);
    }
}
