<?php

namespace App\Payment;

class TestBank extends Payment
{

    protected $code = 'testbank';
    public function registerPaymentOrder($order_reference, $total_amount, $event_id, $secondsToExpire): RegistrationResponse
    {
        return $this->parseResponse([$order_reference,$event_id]);
    }

    protected function parseResponse($response): RegistrationResponse
    {
        return  new TestRegResponse($response);
    }

    public function getPaymentStatus($orderId):StatusResponse{
        return new TestStatusResponse();
    }
}