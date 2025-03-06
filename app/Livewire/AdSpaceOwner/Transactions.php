<?php

namespace App\Livewire\AdSpaceOwner;

use App\Models\Transaction;
use Livewire\Component;
use App\Livewire\Paginator;

class Transactions extends Paginator
{
    public function render()
    {
        return view('livewire.ad-space-owner.transactions', [
            'transactions' => Transaction::query()
                ->with(['sender', 'coupon'])
                ->where('receiver_id', auth()->id())
                ->when($this->search, fn($q) => $q->whereLike(['sender.name', 'sender.email', 'coupon.number'], $this->search))
                ->latest()
                ->paginate($this->limit)
        ]);
    }
}
