<?php

namespace App\Payment;

class TestRegResponse implements RegistrationResponse
{
    public function __construct(protected $response_data)
    {
    }

    public function isSuccessfull(): bool
    {
        return true;
    }

    public function getReferenceId(): string
    {
        return $this->response_data[0];
    }

    public function getRedirectUrl(): string
    {
       return route('showEventCheckoutPaymentReturn', [
           'event_id' => $this->response_data[1],
           'order_number' => $this->response_data[0],
           'orderId' => $this->response_data[0],
           'method'   => 'testbank',
       ]);
    }

    public function errorMessage(): string
    {
        return "test error messagee";
    }
}