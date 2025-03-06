<?php

namespace App\Livewire\Sponsor\Coupons;

use App\Enums\UserRole;
use App\Models\Coupon;
use App\Models\User;
use Livewire\Component;

class Send extends Component
{
    public string $search = "", $type = "register";
    public Coupon $coupon;

    public function mount($coupon)
    {
        $this->coupon = $coupon;
    }

    public function render()
    {
        return view('livewire.sponsor.coupons.send', [
            'users' => User::query()
                ->select(['id', 'name', 'email', 'profile_photo_url'])
                ->withCount(['tickets'])
                ->where('role_id', UserRole::AdSpaceOwner->value)
                ->when($this->search, fn($q) => $q->whereLike(['name', 'email'], $this->search))
                ->get()
        ]);
    }

    public function changeType($type)
    {
        $this->type = $type;
    }
}
