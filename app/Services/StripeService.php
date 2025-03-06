<?php

namespace App\Services;

/**
 * Class StripeService.
 */
class StripeService extends StripeClient
{
    public function payment_intent(array $args)
    {
        return $this->stripe->paymentIntents->create([
            'customer' => $args['stripe_customer_id'],
            'amount' => round($args['amount'] * 100),
            'currency' => 'USD',
            'automatic_payment_methods' => [
                'enabled' => 'true',
            ],
            'payment_method' => $args['payment_method_id'],
            'return_url' => $args['return_url'],
            'off_session' => true,
            'confirm' => true,
            "description" => isset($args['description']) ? $args['description'] : '',
            "metadata" => isset($args['metadata']) ? $args['metadata'] : [],
        ]);
    }

    public function transfer(array $args)
    {
        return $this->stripe->transfers->create([
            'amount' => round($args['amount'] * 100),
            'currency' => 'USD',
            'destination' => $args['destination'],
            'source_transaction' => $args['chargeId'],
        ]);
    }
}
