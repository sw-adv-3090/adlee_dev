<?php

namespace App\Livewire\Sponsor;

use App\Enums\TemplateLanguage;
use App\Enums\TemplateType;
use App\Models\SponsorTemplate;
use App\Models\Template;
use Livewire\Component;

class Templates extends Component
{
    public string $language = TemplateLanguage::ENGLISH->value;
    public array $selectedTemplates = [];
    public array $templateCategories = [];
    public array $selectedCategories = [];

    public function render()
    {
        $templatesByCategories = Template::query()
            ->select(['id', 'uuid', 'title', 'view', 'preview', 'language', 'category_id', 'sub_category_id'])
            ->whereLanguage($this->language)
            ->whereType(TemplateType::SPONSOR->value)
            ->whereActive(true)
            ->whereDate('publish_at', '<=', now())
            ->get()
            ->groupBy('category_id');

        $this->templateCategories = [];
        foreach ($templatesByCategories as $categoryId => $templates) {
            $this->templateCategories[] = $categoryId;
        }

        return view('livewire.sponsor.templates', [
            'categories' => $templatesByCategories
        ]);
    }

    public function toggleTemplates($id, $categoryId)
    {
        if (in_array($id, $this->selectedTemplates)) {
            // remove templates from the list
            $key = array_search($id, $this->selectedTemplates);
            unset($this->selectedTemplates[$key]);

            // remove category from the list
            $key = array_search($categoryId, $this->selectedCategories);
            unset($this->selectedCategories[$key]);
        } else {
            // adding template to the list
            $this->selectedTemplates[] = $id;

            // adding category to the list
            $this->selectedCategories[] = $categoryId;
        }
    }

    public function saveTemplates()
    {
        // make sure user has select template from each category
        if (count($this->templateCategories) != count(array_unique($this->selectedCategories))) {
            // $this->js("alert('Please select atleast one template from each category.')");
            session()->flash('error', 'Please select atleast one template from each category.');
            return;
        }

        // saving the selected templates to database
        foreach ($this->selectedTemplates as $templateId) {
            $template = Template::select(['category_id', 'sub_category_id'])->find($templateId);
            SponsorTemplate::updateOrCreate(['user_id' => auth()->id(), 'template_id' => $templateId], [
                'sponsor_id' => auth()->user()->sponsor->id,
                'category_id' => $template->category_id,
                'sub_category_id' => $template->sub_category_id,
            ]);
        }

        return to_route('sponsors.dashboard')->with('status', 'You have successfully complated onboarding process.');

    }
}
