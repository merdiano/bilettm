<?php

namespace App\Payment;

class TestStatusResponse implements StatusResponse
{

    public function isSuccessfull(): bool
    {
        return true;
    }

    public function getPaymentReferenceId(): string
    {
        return request()->get('order_number');
    }

    public function getPaymentInfo()
    {
        return [];
    }
}