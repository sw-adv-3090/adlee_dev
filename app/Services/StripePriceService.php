<?php

namespace App\Services;

/**
 * Class StripePriceService.
 */
class StripePriceService extends StripeClient
{
    public function create($productId, $price)
    {
        return $this->stripe->prices->create([
            'currency' => 'usd',
            'unit_amount' => $price * 100,
            'recurring' => ['interval' => 'month'],
            'product' => $productId
        ]);
    }

    public function update($priceId, $price)
    {
        return $this->stripe->prices->update($priceId, [
            'unit_amount' => $price * 100,
        ]);
    }
}
