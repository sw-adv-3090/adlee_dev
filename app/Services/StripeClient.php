<?php

namespace App\Services;

/**
 * Class StripePriceService.
 */
class StripeClient
{
    protected $stripe;

    function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('services.stripe.client_secret'));
    }
}
