<?php

namespace App\Payment;

class SenagatRegistrationResponse extends AltynAsyrRegistrationResponse
{
    public function isSuccessfull():bool
    {
        return isset($this->response_data['formUrl']) && isset($this->response_data['orderId']);
    }

}