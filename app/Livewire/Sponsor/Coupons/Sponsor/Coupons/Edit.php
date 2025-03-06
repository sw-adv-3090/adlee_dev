<?php

namespace App\Livewire\Sponsor\Coupons;

use App\Enums\TemplateLanguage;
use App\Enums\TemplateType;
use App\Models\Coupon;
use App\Models\Template;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public string $step = "info";
    public string $title, $amount, $confirm_amount, $payout_deadline;
    public string $language, $template_id = "";
    public string $search = "";
    public Coupon $coupon;

    public $coupon_min_amount = 1;

    public function mount($coupon)
    {
        $this->coupon = $coupon;
        $this->language = $this->coupon->language;
        $this->title = $this->coupon->title;
        $this->amount = $this->coupon->amount;
        $this->confirm_amount = $this->coupon->amount;
        $this->payout_deadline = $this->coupon->payout_deadline;
        $this->template_id = $this->coupon->template_id;
    }

    public function render()
    {
        return view('livewire.sponsor.coupons.edit', [
            'templates' => Template::whereType(TemplateType::COUPON->value)->whereLanguage($this->language)->when($this->search, fn($q) => $q->whereLike(['title'], $this->search))->get()
        ]);
    }

    public function updatedLanguage()
    {
        $this->template_id = "";
    }

    public function changeStep($step)
    {
        $this->step = $step;
    }

    public function selectTemplate($id)
    {
        $this->template_id = $id;
    }

    public function validateInfo()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:' . $this->coupon_min_amount],
            'confirm_amount' => ['required', 'numeric', 'min:' . $this->coupon_min_amount, 'same:amount'],
            'payout_deadline' => ['required'],
        ]);

        $this->step = "template";
    }
    public function update()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:' . $this->coupon_min_amount],
            'confirm_amount' => ['required', 'numeric', 'min:' . $this->coupon_min_amount, 'same:amount'],
            'payout_deadline' => ['required'],
            'language' => ['required', Rule::enum(TemplateLanguage::class)],
            'template_id' => ['required', 'exists:templates,id'],
        ], [
            'template_id.required' => 'Please select a template',
            'template_id.exists' => 'The selected template does not exist.'
        ]);

        $this->coupon->update([
            'title' => $this->title,
            'amount' => $this->amount,
            'payout_deadline' => $this->payout_deadline,
            'language' => $this->language,
            'template_id' => $this->template_id,
        ]);
        return to_route('sponsors.coupons.edit', $this->coupon)->with('success', 'Coupon updated successfully.');

    }
}
