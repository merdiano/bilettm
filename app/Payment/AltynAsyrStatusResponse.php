<?php

namespace App\Payment;

class AltynAsyrStatusResponse implements StatusResponse
{
    public function __construct(protected $response_data)
    {
    }

    public function isSuccessfull(): bool
    {
        return $this->response_data['ErrorCode'] == 0
            && $this->response_data['OrderStatus'] == 2;
    }

    public function getPaymentReferenceId(): string
    {
        return $this->response_data['OrderNumber'];
    }

    public function getPaymentInfo()
    {

        return [
            'payment_card_pan' => $this->response_data['Pan'],
            'payment_card_expiration'=> $this->response_data['expiration'],
            'payment_card_holder_name'=> $this->response_data['cardholderName'],
            'payment_order_status'=> $this->response_data['OrderStatus'],
            'payment_error_code'=> $this->response_data['ErrorCode'],
            'payment_error_message' => $this->response_data['ErrorMessage']
        ];

    }
}