<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\SubCategory;
use Livewire\Component;

class TemplateCategory extends Component
{
    public $categoryId = null;
    public $subCategoryId = null;
    public $categories = [];
    public $subCategories = [];

    public function mount($category_id = null, $sub_category_id = null)
    {
        $this->categories = Category::get();
        $this->categoryId = $category_id;
        $this->subCategoryId = $sub_category_id;
    }

    public function render()
    {
        return view('livewire.template-category');
    }

    public function updatedCategoryId()
    {
        $this->subCategories = SubCategory::where('category_id', $this->categoryId)->get();
    }
}
