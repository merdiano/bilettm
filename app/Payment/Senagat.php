<?php

namespace App\Payment;

use App\Models\Order;

class Senagat extends AltynAsyr
{
    protected $code  = 'senagat';

    private function parseResponse($response){
        return new SenagatRegistrationResponse(json_decode($response, true));
    }
}