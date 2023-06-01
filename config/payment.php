<?php
/**
 * Created by PhpStorm.
 * User: merdan
 * Date: 8/15/2019
 * Time: 17:56
 */
return [
    'altynasyr' => [
        'base_uri' => env('ALTYNASYR_PAYMENT_API_URI'),
        'form_params' => [
            'userName' => env('ALTYNASYR_PAYMENT_API_USER'),
            'password' => env('ALTYNASYR_PAYMENT_API_PASSWORD'),
            'language' => 'ru',
            'currency'    => 934,
        ],
        'class' => \App\Payment\AltynAsyr::class,
        'title' => "Altyn Asyr (Halkbank)",
        'code' => 'altynasyr'
    ],
//    'tfeb' =>[
//        'base_uri' => env('TFEB_PAYMENT_API_URI'),
//        'client_id' => env('TFEB_PAYMENT_API_USER'),
//        'client_secret' => env('TFEB_PAYMENT_API_PASSWORD'),
//        'merchant' => env('TFEB_PAYMENT_API_PASSWORD'),
//        'terminal' => env('TFEB_PAYMENT_API_PASSWORD'),
//        'class' => \App\Payment\Vneshka::class,
//        'title' => "Milli Kart (Türkmenistanyň döwlet daşary ykdysady iş banky)",
//        'code' => 'tfeb'
//    ],
    'senagat' => [
        'base_uri' => env('SENAGAT_PAYMENT_API_URI'),
        'form_params' => [
            'userName' => env('SENAGAT_PAYMENT_API_USER'),
            'password' => env('SENAGAT_PAYMENT_API_PASSWORD'),
            'language' => 'ru',
            'currency'    => 934,
        ],
        'class' => \App\Payment\Senagat::class,
        'title' => "Senagat bank",
        'code' => 'senagat'
    ],
    'rysgal' => [
        'base_uri' => env('RYSGAL_PAYMENT_API_URI'),
        'form_params' => [
            'userName' => env('RYSGAL_PAYMENT_API_USER'),
            'password' => env('RYSGAL_PAYMENT_API_PASSWORD'),
            'language' => 'ru',
            'currency'    => 934,
        ],
        'class' => \App\Payment\Rysgal::class,
        'title' => "Maestro (Rysgalbank)",
        'code' => 'rysgal'
    ],
    'testbank' => [
        'code' => 'testbank',
        'title' => 'TestBAnk',
        'class' => \App\Payment\TestBank::class,
        'base_uri' => ''
    ]
];
