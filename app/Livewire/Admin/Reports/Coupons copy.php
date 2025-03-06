<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Coupon;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Coupons extends Component
{
    use WithPagination;

    public array $filters = [];
    public array $filter = [];
    public $value, $operator, $search, $start, $end;


    public function mount()
    {
        $this->filters = coupons_filters();
    }

    public function render()
    {
        return view('livewire.admin.reports.coupons', [
            'coupons' => Coupon::with(['template', 'task:id,coupon_id,printed_at,signed_at,template_id', 'transactions:coupon_id,amount,created_at', 'sponsor', 'user:id,name,email'])->latest()->paginate(5)
        ]);
    }


    public function updatedValue()
    {
        $this->filter = collect($this->filters)->filter(function ($item) {
            return $item['value'] === $this->value;
        })->first();
    }
}
