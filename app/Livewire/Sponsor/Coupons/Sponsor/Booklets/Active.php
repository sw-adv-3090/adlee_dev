<?php

namespace App\Livewire\Sponsor\Booklets;

use App\Livewire\Paginator;
use App\Models\Booklet;
use App\Models\Coupon;

class Active extends Paginator
{
    public function render()
    {
        // dd(Booklet::withCount(['shipments'])->where('number', 'MS0004')->first());
        return view('livewire.sponsor.booklets.active', [
            'booklets' => Booklet::query()
                ->with(['template'])
                ->withCount(['coupons'])
                ->whereHas('shipments')
                ->where('user_id', auth()->id())
                ->when($this->search, fn($q) => $q->whereLike(['title', 'number'], $this->search))
                ->paginate($this->limit)
        ]);
    }

    public function print($bookletId)
    {
        $this->dispatch('pirnt-booklet', route: route('sponsors.booklets.print.index', $bookletId));
    }
}
