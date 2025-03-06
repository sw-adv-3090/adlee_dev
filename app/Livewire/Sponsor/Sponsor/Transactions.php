<?php

namespace App\Livewire\Sponsor;

use App\Models\Transaction;
use Livewire\Component;
use App\Livewire\Paginator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvoice;

class Transactions extends Paginator
{
    public function render()
    {
        return view('livewire.sponsor.transactions', [
            'transactions' => Transaction::query()
                ->with(['receiver', 'coupon'])
                ->where('sender_id', auth()->id())
                ->when($this->search, fn($q) => $q->whereLike(['receiver.name', 'receiver.email', 'coupon.number'], $this->search))
                ->latest()
                ->paginate($this->limit)
        ]);
    }


    public function downloadInvoice(Transaction $transaction)
    {
        $transaction->load(['sender', 'receiver', 'sponsor', 'company']);

        Mail::to($transaction->sender)->send(new SendInvoice($transaction, 'sponsor'));

        session()->flash('status', "Invoice has been send successfully.");
    }
}
