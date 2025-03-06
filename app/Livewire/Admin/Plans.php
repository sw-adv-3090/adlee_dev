<?php

namespace App\Livewire\Admin;

use App\Models\Plan;
use Livewire\Component;

class Plans extends Component
{
    public function render()
    {
        return view('livewire.admin.plans', ['plans' => Plan::get()]);
    }

    public function updateStatus($id)
    {
        $plan = Plan::find($id);
        $plan->update(['status' => !$plan->status]);


    }
}
