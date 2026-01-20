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
        'domain' => env('MAILGUN_DOMAIN', 'mg.tilalr.com'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'telr' => [
        'store_id' => env('TELR_STORE_ID', '25484'),
        'auth_key' => env('TELR_AUTH_KEY', 'tF@zx^Gq5W'),
        'test_mode' => env('TELR_TEST_MODE', true),
    ],

    'moyasar' => [
        'publishable_key' => env('MOYASAR_API_KEY', 'pk_live_JjGYt4f9iWDGpc9uCE9FCMBvZ9u5FBa5SsQvEFAY'),
        'secret_key' => env('MOYASAR_SECRET_KEY', 'sk_live_CqsRUfH7SJ5H2dnJvdk654F4LvZb9FZs7ipNwyZJ'),
        'test_mode' => env('MOYASAR_TEST_MODE', false),
    ],

    'payment_gateway' => env('PAYMENT_GATEWAY', 'moyasar'), // telr, moyasar, test

    /*
    |--------------------------------------------------------------------------
    | SMS Services
    |--------------------------------------------------------------------------
    |
    | Configuration for SMS providers.
    | Set SMS_PROVIDER to: 'taqnyat', 'twilio', or 'log' (development)
    |
    */
    'sms' => [
        'provider' => env('SMS_PROVIDER', 'log'),
    ],

    // Taqnyat.sa SMS Provider (Saudi Arabia)
    // Register at: https://taqnyat.sa
    // API Docs: https://api.taqnyat.sa/
    'taqnyat' => [
        'bearer_token' => env('TAQNYAT_BEARER_TOKEN'),
        'sender' => env('TAQNYAT_SENDER'),
    ],

    // Twilio SMS Provider
    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],

];