<?php

namespace App\Payment;

use App\Models\Order;
use App\Services\EventOrderService as OrderService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

abstract class Payment
{
    public function __construct($headers = null)
    {
        $config = [
            'timeout' => env('PAYMENT_TIMEOUT',30),
            'connect_timeout' => env('CONNECT_TIMEOUT',30),
            'verify' => env('SSL_VERIFY',true),
            'http_errors' => env('HTTP_ERROR',false),
            'base_uri' => config("payment.{$this->code}.base_uri"),
            'headers' => $headers
        ];

        $this->client = new Client($config);
    }

    public abstract function  registerPaymentOrder($order_reference, $total_amount,$event_id,$secondsToExpire):RegistrationResponse;
    protected abstract function parseResponse($response):RegistrationResponse;

}