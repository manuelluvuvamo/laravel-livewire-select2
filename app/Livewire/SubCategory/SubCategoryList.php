<?php

namespace App\Livewire\SubCategory;

use Livewire\Component;

class SubCategoryList extends Component
{

    public ?int $category_id = null;

    public function render()
    {
        $subcategories = \App\Models\SubCategory::when(
            $this->category_id,
            fn($query) =>
            $query->where('category_id', $this->category_id)
        )->paginate(10);

        return view('livewire.sub-category.sub-category-list', compact('subcategories'));
    }

    public function delete($id)
    {
        try {
            $subcategory = \App\Models\SubCategory::findOrFail($id);
            $subcategory->delete();
            $this->dispatch('toast', notify: 'success', title: 'SubCategory', message: 'SubCategory deleted successfully.');
        } catch (\Exception $e) {
            $this->dispatch('toast', notify: 'error', title: 'SubCategory', message: 'An error occurred: ' . $e->getMessage());
        }
    }
}
