<?php

namespace App\Livewire\Document;

use Livewire\Component;

class DocumentList extends Component
{
    public ?int $category_id = null;
    public ?int $subcategory_id = null;

    public function render()
    {
        $documents = \App\Models\Document::when(
            $this->category_id,
            fn($query) =>
            $query->where('category_id', $this->category_id)
        )->when(
            $this->subcategory_id,
            fn($query) =>
            $query->where('subcategory_id', $this->subcategory_id)
        )->paginate(10);

        return view('livewire.document.document-list', compact('documents'));
    }

    public function delete($id)
    {
        try {
            $document = \App\Models\Document::findOrFail($id);
            $document->delete();
            $this->dispatch('toast', notify: 'success', title: 'Document', message: 'Document deleted successfully.');
        } catch (\Exception $e) {
            $this->dispatch('toast', notify: 'error', title: 'Document', message: 'An error occurred: ' . $e->getMessage());
        }
    }
}
