<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;

class CategoryForm extends Component
{
    public $category = null;
    public $state = [];

    public function mount($category = null)
    {
        $this->category = $category;
        if ($category) {
            $this->state = $category->toArray();
        } else {
            $this->state = [
                'name' => '',
            ];
        }
    }

    public function render()
    {
        return view('livewire.category.category-form');
    }

    public function save()
    {
        $this->validate([
            'state.name' => 'required|string|max:255|unique:categories,name,' . $this->category?->id,
        ]);

        try {
            if ($this->category) {
                $this->category->update($this->state);
                $this->dispatch('toast', notify: 'success', title: 'Category', message: 'Category updated successfully.');
            } else {
                Category::create($this->state);
                $this->dispatch('toast', notify: 'success', title: 'Category', message: 'Category created successfully.');
                $this->reset('state');
            }
            $this->resetValidation();
        } catch (\Exception $e) {
            $this->dispatch('toast', notify: 'error', title: 'Category', message: 'An error occurred: ' . $e->getMessage());
        }
    }
}
