<?php

namespace App\Payment;

class AltynAsyrRegistrationResponse implements RegistrationResponse
{
    public function __construct(protected $response_data)
    {
    }

    public function isSuccessfull()
    {
        return $this->response_data['errorCode'] == 0;
    }

    public function getReferenceId()
    {
        return $this->response_data['orderId'];
    }

    public function getRedirectUrl()
    {
        return $this->response_data['formUrl'];
    }

    public function errorMessage(){
        return $this->response_data['errorMessage'];
    }
}