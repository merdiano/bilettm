<?php

namespace App\Payment;

interface RegistrationResponse
{
    public function isSuccessfull():bool;
    public function getReferenceId():string;
    public function getRedirectUrl():string;
    public function errorMessage():string;
}