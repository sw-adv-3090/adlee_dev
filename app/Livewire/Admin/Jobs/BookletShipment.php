<?php

namespace App\Livewire\Admin\Jobs;

use App\Models\BookletPrint;
use Livewire\Component;

class BookletShipment extends Component
{
    public BookletPrint $job;
    public array $carriers;
    public array $carrierServices;
    public array $services = [];
    public string $carrier_id;

    public function mount($job, $items)
    {
        $this->job = $job;
        foreach ($items as $carrier) {
            $this->carriers[] = [
                'carrier_id' => $carrier['carrier_id'],
                'name' => $carrier['friendly_name'],
            ];
            foreach ($carrier['services'] as $service) {
                $this->carrierServices[$carrier['carrier_id']][] = [
                    'service_code' => $service['service_code'],
                    'name' => $service['name'],
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.jobs.booklet-shipment');
    }

    public function updatedCarrierId()
    {
        $this->services = $this->carrierServices[$this->carrier_id] ?? [];
    }
}
