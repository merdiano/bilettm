<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\ReservedTickets;
use App\Payment\CardPayment;
use App\Services\EventOrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProcessPayment extends Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $session_data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order,$session_data = false)
    {
        $this->order = $order;
        $this->session_data = $session_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CardPayment $gateway)
    {
        Log::info('Dispatching ProcessPayment Job');
        $response = $gateway->getPaymentStatus($this->order->transaction_id);
        if ($response->isSuccessfull()) {
            Log::info('ProcessPayment Job payment is successful for order id: '.$this->order->id);

            $res = $this->session_data ? EventOrderService::completeOrder($this->session_data, $this->order):
            EventOrderService::mobileCompleteOrder($this->order->event_id,$this->order->transaction_id);
        }
        else{
            //todo send mail that order is unsuccessfull;
            Log::info('ProcessPayment Job payment is unsuccessful for order id: '.$this->order->id);
        }

        ReservedTickets::where('event_id', $this->order->event_id)
            ->where('session_id',$this->order->session_id)
            ->whereNotNull('expects_payment_at')
            ->delete();
    }
}
