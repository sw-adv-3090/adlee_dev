<?php

namespace App\Livewire\AdSpaceOwner\Coupons;

use App\Enums\TemplateLanguage;
use App\Enums\TemplateType;
use App\Models\Coupon;
use App\Models\SponsorTemplate;
use App\Models\Task;
use App\Models\DesignerTemplate as TemplateModel;
use App\Notifications\CouponRedeemed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Template extends Component
{
    public Coupon $coupon;
    public Task $task;
    public string $language = "";
    public bool $showLanguages = false;
    public int|null $selectedTemplate = null;
    public $sponsorTemplatesId = [];
    

    public function mount(Coupon $coupon)
    {
        $this->coupon = $coupon;
        $this->task = $coupon->task;
        $sponsor = $coupon->sponsor;
        $this->sponsorTemplatesId = SponsorTemplate::where('sponsor_id', $sponsor->id)->pluck('template_id');

        if ($this->task->language === "hebrew") {
            $this->language = TemplateLanguage::HEBREW->value;
        } elseif ($this->task->language === "both") {
            $this->showLanguages = true;
            $this->language = TemplateLanguage::ENGLISH->value;
        } else {
            $this->language = TemplateLanguage::ENGLISH->value;
        }
    }

    public function render()
    {
        return view('livewire.ad-space-owner.coupons.template', [
            'templates' => TemplateModel::query()
                ->with(['category'])
                ->select(['id', 'uuid', 'title', 'preview', 'language', 'category_id', 'sub_category_id'])
                ->whereLanguage($this->language)
                ->whereType(TemplateType::SPONSOR->value)
                // ->whereActive(true)
                ->whereIn('id', $this->sponsorTemplatesId)
                ->whereDate('publish_at', '<=', now())
                ->get()
        ]);
    }

    public function updatedLanguage()
    {
        $this->selectedTemplate = null;
    }

    public function selectTemplate($templateId)
    {
        $this->selectedTemplate = $templateId;
    }

    public function saveTemplate()
    {
        DB::transaction(function () {
            $this->task->update([
                'template_id' => $this->selectedTemplate,
                'assign_to' => auth()->id()
            ]);

            $this->coupon->update([
                'redeemed_by' => auth()->user()->email,
                'redeemed_at' => now(),
            ]);

            Notification::send($this->coupon->user, new CouponRedeemed($this->coupon));
        });

        if (!is_null($this->coupon->redeemed_by)) {
            // through BBO to provide his consent through e-signature,
            session()->flash('status', "Coupon was successfully redeemed. You will now need to provide your consent through e-signature and click 'print' which will be recorded, in order to be paid.");
            // return $this->redirect('/ad-space-owner/coupons?coupon_id=' . $this->coupon->uuid);
            return $this->redirect('/ad-space-owner/coupons/' . $this->coupon->uuid . '/sign');
        }
    }
}
