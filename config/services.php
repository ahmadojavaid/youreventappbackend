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
        'domain' => env('sandbox31784b34666646ae844f48c811d9c770.mailgun.org'),
        'secret' => env('key-a78b0a0706a6bef90ef8034606e6befa'),
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
    'linkedin' => [
        'client_id' => '77owrvf5wkh5ui',
        'client_secret' => 'Qn6kRKEkdBInJg8M',
        'redirect' => 'http://eventApp.temp/callback/linkedin'
    ],

];
