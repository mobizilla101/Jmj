<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default SEO Configuration
    |--------------------------------------------------------------------------
    */

    'author' => 'MyMobi Team',
    'description' => 'Welcome to MyMobi - Your ultimate platform for gadgets and electronics.',
    'keywords' => 'gadgets, electronics, mobile, tablet, laptop, buy, sell, exchange',
    'robots' => 'index, follow',

    /*
    |--------------------------------------------------------------------------
    | Open Graph & Social Media Defaults
    |--------------------------------------------------------------------------
    */

    'og' => [
        'type' => 'website',
        'title' => 'MyMobi - Your Gadget Marketplace',
        'description' => 'Buy, sell, and exchange your gadgets with transparency.',
        'url' => env('APP_URL', 'http://localhost'),
        'image' => env('APP_URL', 'http://localhost') . '/assets/images/default-og-image.jpg', // Use env() for base URL
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Card Defaults
    |--------------------------------------------------------------------------
    */
    'twitter' => [
        'card' => 'summary_large_image',
        'image' => env('APP_URL', 'http://localhost') . '/assets/images/default-twitter-image.jpg', // Use env() here
    ],
];
