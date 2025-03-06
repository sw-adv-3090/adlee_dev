<?php

namespace App\Services;

/**
 * Class StripeProductService.
 */
class StripeProductService extends StripeClient
{
    public function create($name)
    {
        return $this->stripe->products->create([
            'name' => $name,
        ]);
    }

    public function update($id, $name)
    {
        return $this->stripe->products->update($id, ['name' => $name]);
    }

    public function delete($id)
    {
        return $this->stripe->products->delete($id);
    }
}
