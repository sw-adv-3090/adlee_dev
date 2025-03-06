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
        'token' => env('POSTMARK_TOKEN'),
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

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_API_KEY'),
        'client_secret' => env('TWITTER_CLIENT_API_SECRET_KEY'),
        'redirect' => env('TWITTER_REDIRECT'),
    ],

    'replace_url' => env('REPLACE_URL'),

    'stripe' => [
        'public_key' => env('STRIPE_KEY'),
        'client_secret' => env('STRIPE_SECRET'),
    ],

    'tincorrect' => [
        'base_url' => 'https://api.tincorrect.com',
        'username' => env('TIN_CORRECT_USERNAME'),
        'password' => env('TIN_CORRECT_PASSWORD'),
    ],

    'boldsign' => [
        'api_key' => env('BOLDSIGN_API_KEY'),
        'template_id' => env('BOLDSIGN_TEMPLATE_ID'),
    ],

    'tapfiliate' => [
        'base_url' => 'https://api.tapfiliate.com/1.6',
        'account_id' => env('TAPFILIATE_ACCOUNT_ID'),
        'api_key' => env('TAPFILIATE_API_KEY'),
    ],

    'shipengine' => [
        'base_url' => 'https://api.shipengine.com/v1',
        'api_key' => env('SHIPENGINE_API_KEY'),
    ],
];
