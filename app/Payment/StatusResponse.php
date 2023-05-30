<?php

namespace App\Payment;

interface StatusResponse
{
    public function isSuccessfull():bool;
    public function getPaymentReferenceId():string;
    public function getPaymentInfo();

}