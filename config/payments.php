<?php

return [
    [
        'name' => 'Cash On Delicery', // Cash on Delivery
        'enabled' => true, // Toggle to enable/disable this payment method
        'key' => 'cod',
        'description' => 'Pay with cash upon delivery',
        'logo' => null,
        'icon' => "fas-shipping-fast",
        'token' => null, // Token not needed for COD
    ],
    [
        'name' => 'Paypal',
        'enabled' => false,
        'key' => 'paypal',
        'logo' => null,
        'icon' => null,
        'description' => 'Pay using PayPal',
        'token' => env('PAYPAL_TOKEN', 'your-paypal-token-here'), // Fetch from .env
    ],
    [
        'name' => 'Stripe',
        'enabled' => false,
        'key' => 'stripe',
        'icon' => null,
        'logo' => null,
        'description' => 'Pay using Stripe',
        'token' => env('STRIPE_TOKEN', 'your-stripe-token-here'), // Fetch from .env
    ],
];
