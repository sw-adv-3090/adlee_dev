<?php

namespace App\Livewire\Admin\Templates;

use App\Enums\TemplateType;
use App\Models\Template;
use Livewire\Component;
use Livewire\WithPagination;

class Coupons extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.admin.templates.coupons', [
            'templates' => Template::whereType(TemplateType::COUPON->value)->when($this->search, fn($q) => $q->whereLike(['title'], $this->search))->get()
        ]);
    }
}
