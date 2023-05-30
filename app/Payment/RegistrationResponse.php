<?php

namespace App\Payment;

interface RegistrationResponse
{
    public function isSuccessfull();
    public function getReferenceId();
    public function getRedirectUrl();
    public function errorMessage();
}