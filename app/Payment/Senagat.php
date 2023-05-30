<?php

namespace App\Payment;

use App\Models\Order;

class Senagat extends Payment
{
    protected $code  = 'senagat';

    public function registerPaymentOrder(Order $order)
    {
        // TODO: Implement registerPaymentOrder() method.
    }
}