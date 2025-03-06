<?php

namespace App\Livewire;

use App\Models\SubCategory;
use Livewire\Component;

class UpsertSubCategories extends Component
{
    public array $subCategories = [];

    public function mount($sub_categories = [])
    {
        foreach ($sub_categories as $item) {
            $this->subCategories[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
    }

    public function render()
    {
        return view('livewire.upsert-sub-categories');
    }

    public function addSubCategory()
    {
        $this->subCategories[] = [
            'id' => '',
            'name' => '',
        ];
    }

    public function deleteSubCategory($item, $index)
    {
        try {
            if (isset($item['id'])) {
                SubCategory::find($item['id'])->delete();
            }

            unset($this->subCategories[$index]);
        } catch (\Throwable $th) {
            $this->js("alert(" . $th->getMessage() . ")");
        }


    }
}
