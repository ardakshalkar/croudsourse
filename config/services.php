<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'github' => [
        'client_id' => 'c1a3d4e7e99650331972',         // Your GitHub Client ID
        'client_secret' => '4f03aafa1060bf89abce10ef0269c293158b981c', // Your GitHub Client Secret
        'redirect' => 'http://127.0.0.1:8000/auth/github/callback',
    ],
    'facebook' => [
        'client_id' => '607424906293476',         // Your GitHub Client ID
        'client_secret' => 'e70ac80918793aee6f8ac406c5fbc3e0', // Your GitHub Client Secret
        'redirect' => 'http://127.0.0.1:8000/auth/facebook/callback',
    ],
    'twitter' => [
        'client_id' => 'R2WUIGqmLUlXHq8Va8SgQKa4N',         // Your GitHub Client ID
        'client_secret' => 'Y9RwlNDRCgWFMfBY9UNG0SKHDJy5Kt4red34mu0NCYzKSDMh7K', // Your GitHub Client Secret
        'redirect' => 'http://127.0.0.1:8000/auth/twitter/callback',
    ],
    'google' => [
        'client_id' => '485662643542-gc9gmrucsg17lnurc3mdi90gfg3mlnsi.apps.googleusercontent.com',         // Your GitHub Client ID
        'client_secret' => '45RPYUCKelv-C0yj6DZ6RpkQ', // Your GitHub Client Secret
        'redirect' => 'http://127.0.0.1:8000/auth/google/callback',
    ],

];
