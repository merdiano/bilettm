<?php

namespace App\Payment;

class VneshkaStatusResponse implements StatusResponse
{

    public function __construct(protected $response_data)
    {
    }

    public function isSuccessfull(): bool
    {
        return $this->response_data['response']['operationResult'] == 'GEN-00000';
    }

    public function getPaymentReferenceId(): string
    {
        return "";
    }

    public function getPaymentInfo()
    {
        return [];
    }
}