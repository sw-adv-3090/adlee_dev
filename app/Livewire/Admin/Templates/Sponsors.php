<?php

namespace App\Livewire\Admin\Templates;

use App\Enums\TemplateType;
use App\Models\Template;
use Livewire\Component;
use Livewire\WithPagination;

class Sponsors extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.admin.templates.sponsors', [
            'templates' => Template::whereType(TemplateType::SPONSOR->value)->when($this->search, fn($q) => $q->whereLike(['title'], $this->search))->get()
        ]);
    }
}
