<?php

namespace App\Payment;

class AltynAsyrRegistrationResponse implements RegistrationResponse
{
    public function __construct(protected $response_data)
    {
    }

    public function isSuccessfull():bool
    {
        return $this->response_data['errorCode'] == 0;
    }

    public function getReferenceId():string
    {
        return $this->response_data['orderId'];
    }

    public function getRedirectUrl():string
    {
        return $this->response_data['formUrl'];
    }

    public function errorMessage():string
    {
        return $this->response_data['errorMessage'];
    }
}