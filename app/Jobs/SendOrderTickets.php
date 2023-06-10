<?php

namespace App\Jobs;

use App\Mailers\OrderMailer;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class SendOrderTickets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $order;
    public $maxExceptions = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OrderMailer $orderMailer)
    {
        //$this->dispatchNow(new GenerateTicket($this->order->order_reference));
        $orderMailer->sendOrderTickets($this->order);
    }
}
