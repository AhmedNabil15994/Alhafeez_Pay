<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    "sms"=>[
        "have_sms"=> env("HAVE_SMS", true),
        "default" => env("SMS_DEFAULT", "sms_box"),
        "test"    => env("SMS_TEST", true),
        "sms_box"=>[
            "username" => env("SMS_BOX_USERNAME", "test"),
            "password" => env("SMS_BOX_PASSWORD", "password") ,
            "customerId"=> env("SMS_BOX_CUSTOMER_ID", "2911") ,
            "senderText"=> env("SMS_BOX_SENDER_TEXT", "test"),
            "defdate"   => env("SMS_BOX_DEF_DATE", ""),
            "isBlink"  => env("SMS_BOX_IS_BLINK", "false"),
            "isFlash"  => env("SMS_BOX_IS_FLASH", "false"),
        ]
    ],
    "fcm"=> [
        "server"=> env("FCM_SERVER", "AAAAYgLPcvo:APA91bFZhQolTu2XhzI4Wcl-B9IvzH0AYw2buhQThG9LS-9ymEUo4erLMJq2tVcLZ-j9tZ9ip_QRpyPxnz4sk8JSSDSKTy92Mb2dVtfC3_EEKi6JurwgsbJCqn3-Kwh376JR5Xs5nA8B")
    ]
];
