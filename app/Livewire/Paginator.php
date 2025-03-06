<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Paginator extends Component
{
    use WithPagination, WithoutUrlPagination;

    public string $search = "";
    public string $limit = "10";


    public function updatedLimit()
    {
        $this->resetPage();
    }
}
