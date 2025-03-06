<?php

namespace App\Livewire\Sponsor;

use App\Livewire\Paginator;
use App\Models\BankAccount;

class BankAccounts extends Paginator
{
    public function render()
    {
        return view('livewire.sponsor.bank-accounts', [
            'accounts' => BankAccount::query()
                ->whereBelongsTo(auth()->user())
                ->when($this->search, fn($q) => $q->whereLike(['bank_name', 'last4'], $this->search))
                ->paginate($this->limit)
        ]);
    }
}
