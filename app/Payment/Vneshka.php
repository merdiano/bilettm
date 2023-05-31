<?php

namespace App\Payment;

use App\Models\Order;

class Vneshka extends Payment
{
    protected $code  = 'tfeb';

    public function __construct()
    {
        $headers = [
            'ClientId' =>  config("payment.".$this->code.".client_id"),
            'ClientSecret' => config("payment.".$this->code.".client_secret"),
            'Accept' => "application/hal+json",
            "Content-Type" => 'application/json'
        ];
        parent::__construct($headers);
    }

    public function registerPaymentOrder($order_reference, $total_amount, $event_id,$secondsToExpire): RegistrationResponse
    {
        $data = [
            "RequestId" => $order_reference,
            "Environment" => [
                "Merchant" => [
                    "Id" =>config("payment.".$this->code.".merchant")
                ],
                "POI" => [
                    "Id" => config("payment.".$this->code.".terminal"),
                    "Language" => "en-US"
                ],
                "Transport" => [
                    "MerchantFinalResponseUrl" => route('showEventCheckoutPaymentReturn', [
                        'event_id'              => $event_id,
                        'is_payment_successful' => 1
                    ]),
                    "ChallengeResponseUrl" => route('showEventCheckoutPaymentReturn', [
                        'event_id'              => $event_id,
                        'is_payment_successful' => 1
                    ]),
                    "ChallengeWindowSize" => 3,
                    "ChallengeResponseData"=> null,
                    "ThreeDSMethodNotificationUrl"=> "",
                    "MethodCompletion"=> false,
                    "Consent" => false,
                    "EndpointHostAddress" => "/orders/7b72093d-bb14-45b5-a6ec-a3ca5f6c2731"
                ],
                "SponsoredMerchant"=> null,
                "SponsoredMerchantPOI"=> null,
                "Card" => null,
                "CardRecipient"=> null,
                "Customer" => [
                    "Name" => request()->get('order_first_name'),
                    "Language" => "en-US",
                    "Email" => request()->get('order_email'),
                    "HomePhone" => [
                        "cc" => "993",
                        "subscriber" => 63000000
                    ],
                    "MobilePhone" => [
                        "cc" => "993",
                        "subscriber" => 63000000
                    ],
                    "WorkPhone" => null
                ],

                "CustomerDevice" => [
                    "Browser" =>  [
                        "AcceptHeader" => "*/*",
                        "IpAddress" => request()->ip(),
                        "Language" => "en-US",
                        "ScreenColorDepth" => 48,
                        "ScreenHeight" => 1200,
                        "ScreenWidth" => 1900,
                        "UserAgentString" => "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.3"
                    ],
                    "MobileApp" => null,
                ],
                'BillingAddress' => [
                    "SameAsShipping" => true,
                    "Line1"=> 'L1:adres hokman dal',//Line1 must be max 50 chars
                    "Line2"=> 'L2:adres hokman dal',//Line2 must be max 50 chars
                    "PostCode"=> "74000",
                    "City"=> "01",
                    "CountrySubdivision"=> "01",
                    "Country"=> "196"
                ],
                'ShippingAddress' => [
                    "SameAsShipping" => true,
                    "Line1"=> 'L1:adres hokman dal',//Line1 must be max 50 chars
                    "Line2"=> 'L2:adres hokman dal',//Line2 must be max 50 chars
                    "PostCode"=> "74000",
                    "City"=> "01",
                    "CountrySubdivision"=> "01",
                    "Country"=> "196"
                ],

            ],
            "Transaction" => [
                "InvoiceNumber" => "Acquirer",
                "Type" => "CRDP",
                "AdditionalService" => null,
                "TransactionText" => "bilettm online",
                "TotalAmount" => (double)$total_amount,
                "Currency" => "934",
                "CurrencyConversion"=>   null,
                "DetailedAmount"=> null,
                "AirlineItems"=> null,
                "MerchantOrderId" => $order_reference,
                "AutoComplete" => true,
                "Instalment"=> null,
                "MerchantCategoryCode"=> null,
                "AntiMoneyLaundering"=> [
                    "SenderName"=> request()->get('order_first_name'),
                    "SenderDateOfBirth"=> null,
                    "SenderPlaceOfBirth"=> null,
                    "NationalIdentifier"=> null,
                    "NationalIdentifierCountry"=> null,
                    "NationalIdentifierExpiry"=> null,
                    "PassportNumber"=> "123-456",
                    "PassportIssuingCountry"=> null,
                    "PassportExpiry"=> "20291/12/01"
                ],
            ]
        ];

        $request = $this->client->post('',['body' => json_encode($data)]);

        return new VneshkaRegistrationResponse(json_decode($request->getBody(),true));
    }

    public function getPaymentStatus($orderId):StatusResponse{
        $request = $this->client->get($orderId);
        return new VneshkaStatusResponse(json_decode($request->getBody()));
    }
}