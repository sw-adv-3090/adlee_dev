<?php

namespace App\Livewire\Admin\Templates;

use App\Enums\TemplateType;
use App\Models\Template;
use Livewire\Component;

class Overview extends Component
{
    public string $sponsor_bg, $coupon_bg;
    public string $search = '';

    public function render()
    {
        return view('livewire.admin.templates.overview', [
            'templates' => Template::when($this->search, fn($q) => $q->whereLike(['title'], $this->search))->get(),
            'totalTemplates' => Template::count(),
            'sponsorTemplates' => Template::whereType(TemplateType::SPONSOR->value)->count(),
            'couponTemplates' => Template::whereType(TemplateType::COUPON->value)->count(),
        ]);
    }
}
