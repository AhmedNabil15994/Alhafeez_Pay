<?php

return [
    'login' => [
        'validations'   => [
            'user_not_found'    => 'User not found in our records',
            'wrong_credential'    => 'Wrong Credential, Please try again with the correct credentials',
            'enter_email_password' => 'Please enter your e-mail and password.',
        ],
        'remember' => 'Remember me',
        'forgot_password' => 'Forgot password?',
        'forgot_password_desc' => 'Enter your e-mail address below to reset your password.',
    ],
    'register' =>
    [
        'index' => 'Create new account',
        'desc' => 'Enter your personal details below:',
        'form' =>
        [
            're_password' => 'Re-type Your Password',
            'i_agree' => 'I agree to the',
            'fullname' => 'Full Name',
            'terms_of_service' => 'Terms of Service',
            'privacy_policy' => 'Privacy Policy',
            'back' => 'Back',
            'submit' => 'Submit',
            'mobile' => 'Mobile Number',
        ]
    ],
    'verify' =>
    [
        'verify_account' => 'Verify Your Account',
        'token_expired' => 'Sorry!, You are using an expired link, please try re-generate a new one.',
        'generate_link' => 'Send Another Link',
        'loading' => 'Loading...',
        'link_sent' => 'A new link sent, please check your e-mail address.',
    ]
];
