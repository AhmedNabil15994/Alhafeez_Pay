<?php

return [
    "status"=>[
        "not_active" => "User Blocked from adminstration",
        "not_admin_verified" => "Adminstration not verified this account yet",
        "not_verified"       => "Account not verified yet"
    ],
    'forget_password'   => [
        'mail'      => [
            'subject'   => 'Reset Password',
        ],
        'messages'  => [
            'success'   => 'Reset Password Send Successfully',
        ],
    ],
    'login'             => [
        'validation'    => [
            'email'     => [
                'email'     => 'Please enter correct email format',
                'required'  => 'The email field is required',
            ],
            'failed'    => 'These credentials do not match our records.',
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
        ],
    ],
    "resend"=> [
        "success" => "تم ارسال الكود بنجاح"
    ],
    'logout'            => [
        'messages'  => [
            'failed'    => 'logout failed',
            'success'   => 'logout successfully',
        ],
    ],
    'password'          => [
        'messages'      => [
            'sent'  => 'Reset password sent successfully',
        ],
        'validation'    => [
            'email' => [
                'email'     => 'Please enter correct email format',
                'exists'    => 'This email not exists',
                'required'  => 'The email field is required',
            ],
        ],
    ],
    'register'          => [
        'messages'      => [
            'failed'    => 'Register Failed , Please try again later',
            "error_sms" => "ُError in sms messages sender",
            "code_send" => "Your verification code is : :code ",
            "code"      => "verification code not correct" ,
            "already_verified"=> "Mobile is already verified"

        ],
        'validation'    => [
            'email'     => [
                'email'     => 'Please enter correct email format',
                'required'  => 'The email field is required',
                'unique'    => 'The email has already been taken',
            ],
            'mobile'    => [
                'digits_between'    => 'You must enter mobile number with 8 digits',
                'numeric'           => 'The mobile must be a number',
                'required'          => 'The mobile field is required',
                'unique'            => 'The mobile has already been taken',
            ],
            'name'      => [
                'required'  => 'The name field is required',
            ],
            'password'  => [
                'confirmed' => 'Password not match with the cnofirmation',
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
            'title'     => [
                'category_id'   => 'Please select service',
                'required'      => 'Please fill your company name',
            ],
        ],
    ],
    'reset'             => [
        'mail'          => [
            'button_content'    => 'Reset Your Password',
            'header'            => 'You are receiving this email because we received a password reset request for your account.',
            'subject'           => 'Reset Password',
        ],
        'title'         => 'Reset Password',
        'validation'    => [
            'email'     => [
                'email'     => 'Please enter correct email format',
                'exists'    => 'This email not exists',
                'required'  => 'The email field is required',
            ],
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
            'token'     => [
                'exists'    => 'This token expired',
                'required'  => 'The token field is required',
            ],
        ],
    ],
    'workers'           => [],
];
