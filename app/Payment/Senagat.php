<?php

namespace App\Payment;

use App\Models\Order;

class Senagat extends AltynAsyr
{
    protected $code  = 'senagat';

    protected function parseResponse($response):RegistrationResponse{
        return new SenagatRegistrationResponse(json_decode($response, true));
    }
}