<?php

namespace App\Livewire\Admin;

use App\Livewire\Paginator;
use App\Models\Transaction;
use Livewire\WithPagination;

class Reports extends Paginator
{
    use WithPagination;
    public $start, $end;

    public function mount()
    {
        // $this->start = "2024-08-30";
    }

    public function render()
    {
        return view('livewire.admin.reports', [
            'transactions' => Transaction::when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->latest()->paginate(100)
        ]);
    }

    // public function updatedStart()
    // {
    //     dd($this->start);
    // }
}
