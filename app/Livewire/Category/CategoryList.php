<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;

    public function render()
    {
        $categories = \App\Models\Category::paginate(10);
        return view('livewire.category.category-list', compact('categories'));
    }

    public function delete($id)
    {
        try {
            $category = \App\Models\Category::findOrFail($id);
            $category->delete();
            $this->dispatch('toast', notify: 'success', title: 'Category', message: 'Category deleted successfully.');
        } catch (\Exception $e) {
            $this->dispatch('toast', notify: 'error', title: 'Category', message: 'An error occurred: ' . $e->getMessage());
        }
    }
}
