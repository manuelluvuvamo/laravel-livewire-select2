<?php

namespace App\Livewire\SubCategory;

use App\Models\SubCategory;
use Livewire\Component;

class SubCategoryForm extends Component
{
    public $subcategory = null;
    public $category = null;
    public $state = [];

    public function mount($subcategory = null)
    {
        $this->subcategory = $subcategory;
        if ($subcategory) {
            $this->state = $subcategory->toArray();
            $this->category = $subcategory->category;

            $this->dispatch('prefill-select2-subcategory-form', selector: '#categoryList', id: $this->category->id, text: $this->category->name);
        
        } else {
            $this->state = [
                'name' => '',
                'category_id' => '',
            ];
        }
    }

    public function render()
    {
        return view('livewire.sub-category.sub-category-form');
    }
    public function save()
    {
        $this->validate([
            'state.name' => 'required|string|max:255|unique:sub_categories,name,' . $this->subcategory?->id,
        ]);

        try {
            if ($this->subcategory) {
                $this->subcategory->update($this->state);
                $this->dispatch('toast', notify: 'success', title: 'SubCategory', message: 'SubCategory updated successfully.');
            } else {
                SubCategory::create($this->state);
                $this->dispatch('toast', notify: 'success', title: 'SubCategory', message: 'SubCategory created successfully.');
                $this->reset('state');
            }
            $this->resetValidation();
        } catch (\Exception $e) {
            $this->dispatch('toast', notify: 'error', title: 'SubCategory', message: 'An error occurred: ' . $e->getMessage());
        }
    }
}
