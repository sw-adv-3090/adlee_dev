<?php

namespace App\Livewire\Admin\Jobs;

use App\Livewire\Paginator;
use App\Models\BookletPrint;
use Livewire\Component;

class BookletPrints extends Paginator
{
    public function render()
    {
        return view('livewire.admin.jobs.booklet-prints', [
            'requests' => BookletPrint::query()
                ->with(['booklet:id,title,number', 'user:id,name,email,profile_photo_url', 'booklet.coupons:booklet_id', 'shipment'])
                ->when($this->search, fn($q) => $q->whereLike(['booklet.title', 'booklet.number', 'user.name', 'user.email'], $this->search))
                ->latest()
                ->paginate($this->limit)
        ]);
    }
}
