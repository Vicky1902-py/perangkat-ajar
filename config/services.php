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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
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

    /*
    |--------------------------------------------------------------------------
    | NVIDIA NIM API — Sistem Pakar AI Hybrid
    |--------------------------------------------------------------------------
    | Digunakan untuk memperkaya narasi teks perangkat ajar secara otomatis
    | dengan tetap menjaga data CP/TP sebagai sumber kebenaran (anti-halusinasi).
    */
    'nvidia' => [
        'api_key'        => env('NVIDIA_API_KEY', ''),
        'api_url'        => env('NVIDIA_API_URL', 'https://integrate.api.nvidia.com/v1'),
        'model'          => env('NVIDIA_MODEL', 'z-ai/glm-5.3-flash'),
        'fallback_model' => env('NVIDIA_FALLBACK_MODEL', 'deepseek-ai/deepseek-v4.1-flash'),
        'timeout'        => env('NVIDIA_TIMEOUT', 30),
    ],

];
