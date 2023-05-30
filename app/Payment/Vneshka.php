<?php

namespace App\Payment;

use App\Models\Order;

class Vneshka extends Payment
{
    protected $code  = 'tfeb';

    public function registerPaymentOrder(Order $order)
    {
        // TODO: Implement registerPaymentOrder() method.
    }
}