<?php

namespace App\Livewire\Admin;

use App\Models\Coupon;
use App\Livewire\Paginator;

class Coupons extends Paginator
{
    public function render()
    {
        return view('livewire.admin.coupons', [
            'coupons' => Coupon::query()
                ->with(['template', 'task:id,coupon_id,printed_at,signed_at,template_id', 'transactions:coupon_id,amount,created_at'])
                ->withSum('transactions', 'amount')
                ->when($this->search, fn($q) => $q->whereLike(['title', 'number', 'amount'], $this->search))
                ->paginate($this->limit)
        ]);
    }
}
