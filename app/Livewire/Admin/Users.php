<?php

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use App\Livewire\Paginator;
use App\Models\Sponsor;
use App\Models\User;

class Users extends Paginator
{
    public string $type = "";

    public function mount($type)
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.admin.users', [
            'users' => User::query()
                ->select(['id', 'name', 'email', 'profile_photo_url'])
                ->when($this->type === "sponsors", fn($q) => $q->where('role_id', UserRole::Sponsor->value), fn($q) => $q->where('role_id', UserRole::AdSpaceOwner->value))
                ->with(['sponsor:id,user_id,company_name,company_phone,company_logo,ach_support', 'adSpaceOwner:id,user_id,company_name,company_phone,company_logo'])
                ->withCount(['coupons', 'booklets', 'tickets'])
                ->when($this->search, fn($query) => $query->whereLike(['name', 'email', 'sponsor.company_name', 'sponsor.company_phone', 'adSpaceOwner.company_name', 'adSpaceOwner.company_phone'], $this->search))
                // ->latest()
                ->paginate($this->limit)
        ]);
    }

    public function toggleACHSupport($sponsorId)
    {
        $sponsor = Sponsor::find($sponsorId);
        $sponsor->ach_support = !$sponsor->ach_support;
        $sponsor->save();
    }
}
