<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PhonePe Payment Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Supported Environments: 'SANDBOX', 'UAT', 'PRODUCTION'
    |
    */

    'env' => env('PHONEPE_ENV', 'SANDBOX'),

    'merchant_id' => env('PHONEPE_MERCHANT_ID', 'M23FMU2DDFY43'),

    'client_id' => env('PHONEPE_CLIENT_ID', 'M23FMU2DDFY43_2602230918'),

    'client_secret' => env('PHONEPE_CLIENT_SECRET', 'MWIyZmMzZTUtODFiMS00YWE2LTk5NWEtOTU1NzY4OGM1MjIx'),

    'client_version' => (int) env('PHONEPE_CLIENT_VERSION', 1),

    'urls' => [
        'sandbox' => [
            'oauth' => 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
            'pay' => 'https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay',
            'status' => 'https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/order/{merchantOrderId}/status',
        ],
        'production' => [
            'oauth' => 'https://api.phonepe.com/apis/identity-manager/v1/oauth/token',
            'pay' => 'https://api.phonepe.com/apis/pg/checkout/v2/pay',
            'status' => 'https://api.phonepe.com/apis/pg/checkout/v2/order/{merchantOrderId}/status',
        ],
    ],
];
