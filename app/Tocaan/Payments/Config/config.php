<?php
return
[
    /*-------------------------------------------------------------------------------
    + The Library name,
    + It must equals to the same folder name in the path \App\Tocaan\{WhatEverName}
    +-------------------------------------------------------------------------------*/
    'name' => 'Payments',

    /*-------------------------------------------------------------------------------
    + Sandbox mode (The test mode)
    +-------------------------------------------------------------------------------*/
    'sandbox' => env('PAYMENTS_SANDBOX', false),

    /*-------------------------------------------------------------------------------
    + Transaction Number Prefix
    +-------------------------------------------------------------------------------*/
    'prefix' => env('PAYMENTS_TRANSACTIONS_PREFIX', 'TOC-TR-'),

    /*-------------------------------------------------------------------------------
    + Default Currency
    +-------------------------------------------------------------------------------*/
    'currency' => env('PAYMENTS_CURRENCY', 'kwd'),

    /*-------------------------------------------------------------------------------
    + Default payment method
    +-------------------------------------------------------------------------------*/
    'driver' => env('PAYMENTS_DRIVER', 'kpay'),

    /*-------------------------------------------------------------------------------
    + Supported payments methods
    +-------------------------------------------------------------------------------*/
    'drivers' =>
    [
        'kpay' =>
        [
            'name' => 'kpay',
            'visual_name' => 'Pay invoice using Knet card',
            'sandbox_url' => 'https://kpaytest.com.kw/',
            'live_url' => 'https://kpay.com.kw/',
            'request_method' => 'get',
            'webhook_method' => 'get',
            'callback_method' => 'get',
            'auth' => 'body',
            'namepspace' => \App\Tocaan\Payments\Core\Gateways\KPay::class,
            'credentials' =>
            [
                'tranportal_id' => env('KNEY_TRANSPORTAL_ID', 'test'),
                'password' => env('KNEY_PASSWORD', 'test'),
                'resource_key' => env('KNEY_RESOURCE_KEY', 'test'),
            ]
        ],
        'upayments' =>
        [
            'name' => 'uPayments',
            'visual_name' => 'Pay invoice using Knet card',
            'sandbox_url' => 'https://api.upayments.com/test-payment',
            'live_url' => 'https://api.upayments.com/payment-request',
            'request_method' => 'post',
            'webhook_method' => 'post',
            'callback_method' => 'post',
            'auth' => 'body',
            'namepspace' => \App\Tocaan\Payments\Core\Gateways\uPayments::class,
            'credentials' =>
            [
                'username' => env('UPAYMENT_USERNAME', 'test'),
                'password' => env('UPAYMENT_PASSWORD', 'test'),
                'api_key' => env('UPAYMENT_APIKEY', 'jtest123'),
                'merchant_id' => env('UPAYMENT_MERCHANT_ID', '1201')
            ]
        ],
        'myfatoorah' =>
        [
            'name' => 'myFatoorah',
            'visual_name' => 'Pay invoice using Visa/Master Card / Knet',
            'sandbox_url' => 'https://apitest.myfatoorah.com/v2/SendPayment',
            'live_url' => 'https://api.myfatoorah.com/v2/SendPayment',
            'request_method' => 'post',
            'webhook_method' => 'post',
            'callback_method' => 'post',
            'auth' => 'bearer',
            'namepspace' => \App\Tocaan\Payments\Core\Gateways\myFatoorah::class,
            'credentials' =>
            [
                'token' => env('MYFATOORAH_TOKEN', 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL'),
            ]
        ],
        'tap' =>
        [
            'name' => 'Tap',
            'visual_name' => 'Pay invoice using Visa/Master Card / Knet',
            'sandbox_url' => 'https://api.tap.company/v2/charges',
            'live_url' => 'https://api.tap.company/v2/charges',
            'request_method' => 'post',
            'webhook_method' => 'post',
            'callback_method' => 'post',
            'auth' => 'bearer',
            'namepspace' => \App\Tocaan\Payments\Core\Gateways\TapPayments::class,
            'credentials' =>
            [
                'test_token' => env('TAP_TEST_TOKEN', 'sk_test_cAZSzuliNbE20IsQmpXDLTdr'),
                'live_token' => env('TAP_LIVE_TOKEN', null),
            ]
        ],
        'moyasar' =>
        [
            'name' => 'Moyasar',
            'visual_name' => 'Pay invoice using Visa/Master Card / Knet',
            'sandbox_url' => 'https://api.moyasar.com/v1/invoices',
            'live_url' => 'https://api.moyasar.com/v1/invoices',
            'request_method' => 'post',
            'webhook_method' => 'post',
            'callback_method' => 'post',
            'auth' => 'basic_auth',
            'namepspace' => \App\Tocaan\Payments\Core\Gateways\Moyasar::class,
            'credentials' =>
            [
                'username' => env('MOYASAR_TEST_TOKEN', 'sk_test_3FpiDoVwmyrEeTVTabigebMc3P2bUrkDJmTM6eFm'),
                'password' => '', //Always null in Moyasar
            ]
        ]
    ]
];
