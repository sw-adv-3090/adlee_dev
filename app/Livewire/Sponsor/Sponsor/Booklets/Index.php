<?php

namespace App\Livewire\Sponsor\Booklets;

use App\Livewire\Paginator;
use App\Models\Booklet;
use App\Models\Coupon;

class Index extends Paginator
{
    public $printBookletId = "";
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        // dd(Booklet::withCount(['shipments'])->where('number', 'MS0004')->first());
        return view('livewire.sponsor.booklets.index', [
            'booklets' => Booklet::query()
                ->with(['template', 'prints'])
                ->withCount(['coupons', 'activated', 'paids', 'redeemeds', 'allocated', 'prints', 'shipments'])
                ->where('user_id', auth()->id())
                ->when($this->search, fn($q) => $q->whereLike(['title', 'number'], $this->search))
                ->paginate($this->limit)
        ]);
    }

    public function hanldePrintClick($bookletId)
    {
        $this->printBookletId = $bookletId;
    }

    // public function print($bookletId)
    public function print()
    {
        $this->dispatch('pirnt-booklet', route: route('sponsors.booklets.print.index', $this->printBookletId));
    }
}
