<?php

return [
 

    'mode' => env('OTP_MODE', 'fixed'),

    /*
    |--------------------------------------------------------------------------
    | Fixed OTP Code
    |--------------------------------------------------------------------------
    |
    | The OTP code to use when mode is set to "fixed".
    | This is useful for development and testing without SMS integration.
    |
    */
    'fixed_code' => env('OTP_FIXED_CODE', '1234'),

    /*
    |--------------------------------------------------------------------------
    | OTP Expiry (minutes)
    |--------------------------------------------------------------------------
    |
    | How long an OTP code remains valid before expiring.
    |
    */
    'expiry_minutes' => env('OTP_EXPIRY_MINUTES', 5),

    /*
    |--------------------------------------------------------------------------
    | Resend Cooldown (seconds)
    |--------------------------------------------------------------------------
    |
    | Minimum time (in seconds) before a user can request a new OTP.
    |
    */
    'resend_cooldown' => env('OTP_RESEND_COOLDOWN', 60),

    /*
    |--------------------------------------------------------------------------
    | Maximum Attempts
    |--------------------------------------------------------------------------
    |
    | Maximum number of verification attempts before OTP is invalidated.
    |
    */
    'max_attempts' => env('OTP_MAX_ATTEMPTS', 3),

    /*
    |--------------------------------------------------------------------------
    | SMS Provider Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for SMS providers. When OTP_MODE is "sms", the system
    | will use the configured provider to send OTP codes.
    |
    | Supported providers: "taqnyat", "twilio", "unifonic", "custom"
    | 
    | Recommended for Saudi Arabia: taqnyat
    | Set SMS_PROVIDER=taqnyat in .env and configure TAQNYAT_BEARER_TOKEN and TAQNYAT_SENDER
    |
    */
    'sms_provider' => env('SMS_PROVIDER', 'taqnyat'),

    'providers' => [
        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],

        // Saudi SMS Provider (Unifonic)
        'unifonic' => [
            'app_id' => env('UNIFONIC_APP_ID'),
            'sender_id' => env('UNIFONIC_SENDER_ID'),
            'api_url' => env('UNIFONIC_API_URL', 'https://el.cloud.unifonic.com/rest/SMS/messages'),
        ],

        // Custom SMS provider
        'custom' => [
            'url' => env('SMS_CUSTOM_URL'),
            'api_key' => env('SMS_CUSTOM_API_KEY'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | OTP Message Templates
    |--------------------------------------------------------------------------
    |
    | Message templates for different OTP types.
    |
    */
    'messages' => [
        'register' => [
            'en' => 'Your Tilal Rimal verification code is: :code',
            'ar' => 'رمز التحقق الخاص بك في تلال الرمال هو: :code',
        ],
        'login' => [
            'en' => 'Your Tilal Rimal login code is: :code',
            'ar' => 'رمز تسجيل الدخول الخاص بك في تلال الرمال هو: :code',
        ],
    ],
];
