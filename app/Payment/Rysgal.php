<?php

namespace App\Payment;

use App\Models\Order;

class Rysgal extends Payment
{
    protected $code  = 'rysgal';

    public function registerPaymentOrder(Order $order)
    {
        // TODO: Implement registerPaymentOrder() method.
    }
}