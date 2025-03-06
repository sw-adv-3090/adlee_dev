<?php

namespace App\Livewire\Sponsor\Coupons;

use App\Livewire\Paginator;
use App\Models\Coupon;

class Index extends Paginator
{
    public string $booklet_id = "";
    public string $coupon_id = "";
    public array $selected = [];

    public function mount($booklet_id = "")
    {
        $this->booklet_id = $booklet_id;
        if (request()->has('coupon_id')) {
            $this->coupon_id = request()->query('coupon_id');
        }
    }

    public function render()
    {
        $coupon = Coupon::query()
        ->with(['template', 'task:id,coupon_id,printed_at,signed_at,template_id', 'transactions:coupon_id,amount,created_at'])
        ->withSum('transactions', 'amount')
        ->where('user_id', auth()->id())
        ->when(empty($this->booklet_id), fn($q) => $q->whereNull('booklet_id'))
        ->when($this->coupon_id, fn($q) => $q->where('uuid', $this->coupon_id))
        ->when($this->booklet_id, fn($q) => $q->where('booklet_id', $this->booklet_id))
        ->when($this->search, fn($q) => $q->whereLike(['title', 'number'], $this->search))
        ->paginate($this->limit);
        return view('livewire.sponsor.coupons.index', [
            'coupons' => $coupon
        ]);
    }

    public function toggleSelect($type, $payload)
    {
        if ($type == "all") {
            foreach ($payload as $id) {
                $this->toggleIdInArray($id);
            }
        } else {
            $this->toggleIdInArray($payload);
        }


    }

    private function toggleIdInArray($id)
    {
        if (($key = array_search($id, $this->selected)) !== false) {
            // ID found, remove it from array
            unset($this->selected[$key]);
        } else {
            // ID not found, add it to array
            $this->selected[] = $id;
        }

        // Re-index the array to maintain proper numeric indexing
        $this->selected = array_values($this->selected);
    }
}
