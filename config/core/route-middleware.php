<?php

return [
    'dashboard' => [
        'auth' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
            'auth:web',
            'dashboard.auth',
            'check.permission',
        ],
        'guest' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
        ]
    ],

    'frontend' => [
        'auth' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
            'isVendor',
        ],
        'guest' => [
            'web',
            'localizationRedirect',
            'localeSessionRedirect',
            'localeViewPath',
            'localize',
        ]
    ],

    'api' => [
        'auth' => [
            'api',
            // 'auth:api',
        ],
        'guest' => [
            'api',
        ]
    ],
];
