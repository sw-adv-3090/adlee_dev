<?php

namespace App\Livewire\Admin;

use App\Models\Task;
use Livewire\Component;
use App\Livewire\Paginator;

class Tasks extends Paginator
{
    public function render()
    {
        return view('livewire.admin.tasks', [
            'tasks' => Task::query()
                ->with(['sponsor:id,company_name,company_logo', 'company', 'coupon'])
                ->withSum('transactions', 'amount')
                ->whereNotNull(['template_id', 'printed_at'])
                ->whereHas('coupon', fn($q) => $q->whereNull('payout_at'))
                ->when($this->search, fn($q) => $q->whereLike(['sponsor.company_name', 'sponsor.company_logo', 'company.company_logo', 'company.company_name', 'coupon.number', 'coupon.amount'], $this->search))
                ->latest()
                ->paginate($this->limit)
        ]);
    }
}
