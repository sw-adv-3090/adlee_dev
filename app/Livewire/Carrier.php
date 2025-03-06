<?php

namespace App\Livewire;

use Livewire\Component;

class Carrier extends Component
{
    public array $carriers;
    public array $carrierServices;
    public array $services = [];
    public string $carrier_id;

    public function mount($items)
    {
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

        if (settings('carrier_id')) {
            $this->carrier_id = settings('carrier_id');
            $this->services = $this->carrierServices[$this->carrier_id] ?? [];
        }
    }

    public function render()
    {
        return view('livewire.carrier');
    }

    public function updatedCarrierId()
    {
        $this->services = $this->carrierServices[$this->carrier_id] ?? [];
    }
}
