<?php

namespace App\Payment;

class VneshkaRegistrationResponse implements RegistrationResponse
{

    public function __construct(protected $response_data)
    {
    }

    public function isSuccessfull():bool
    {
        return  $this->response_data['response']['operationResult'] == 'OPG-00100';
    }

    public function getReferenceId():string
    {
        return $this->response_data['response']['orderId'];
    }

    public function getRedirectUrl():string
    {
        return $this->response_data['_links']['redirectToCheckout']['href'];
    }

    public function errorMessage():string
    {
        return $this->response_data['response']['operationResultDescription'];
    }
}