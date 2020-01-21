<?php
/**
 * Created by PhpStorm.
 * User: merdan
 * Date: 8/15/2019
 * Time: 17:56
 */
return [
    'card' =>[
        'config' => [
            'base_uri' => env('PAYMENT_API_URI'),
            'timeout' => 10,
            'connect_timeout' => 10,
            'verify' => true,
            'http_errors' => false,
        ],
        'params' => [
            'userName' => env('PAYMENT_API_USER'),
            'password' => env('PAYMENT_API_PASSWORD'),
            'language' => 'ru',
        ]
    ]
];
