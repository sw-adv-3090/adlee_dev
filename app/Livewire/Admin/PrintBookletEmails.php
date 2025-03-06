<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class PrintBookletEmails extends Component
{
    public array $emails;

    public function mount()
    {
        $emails = settings('print-emails');
        $this->emails = !is_null($emails) ? json_decode($emails) : [];
    }

    public function render()
    {
        return view('livewire.admin.print-booklet-emails');
    }

    public function addEmail()
    {
        $this->emails[] = '';
    }

    public function removeEmail($index)
    {
        unset($this->emails[$index]);
    }

    public function save()
    {
        // validate the emails list
        $this->validate([
            'emails.*' => ['required', 'string', 'email']
        ]);

        // save the emails list to the database
        Setting::updateOrCreate([
            'key' => 'print-emails'
        ], [
            'value' => json_encode($this->emails)
        ]);

        // clear the cache so that the new emails list will be reflected in the frontend
        Artisan::call('cache:clear');

        // flash a success message to the admin
        session()->flash('status', 'Print emails list successfully updated.');
    }
}
