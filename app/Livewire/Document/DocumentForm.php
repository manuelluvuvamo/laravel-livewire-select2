<?php

namespace App\Livewire\Document;

use App\Models\Document;
use Livewire\Component;

class DocumentForm extends Component
{
    public $document = null;
    public $subcategory = null;
    public $category = null;
    public $state = [];

    public function mount($document = null)
    {
        $this->document = $document;
        if ($document) {
            $this->state = $document->toArray();
            $this->category = $document->category;
            $this->subcategory = $document->subcategory;

            $this->dispatch('prefill-select2-document-form', selector: '#categoryList', id: $this->category->id, text: $this->category->name);

            $this->dispatch('prefill-select2-document-form', selector: '#subcategoryList', id: $this->subcategory->id, text: $this->subcategory->name);

        } else {
            $this->state = [
                'title' => '',
                'content' => '',
                'category_id' => '',
                'subcategory_id' => '',
            ];
        }

        $this->dispatch('init-summernote');
        $this->dispatch('content-updated', text: $this->state['content']);
    }


    public function render()
    {
        return view('livewire.document.document-form');
    }

    public function save()
    {
        $this->validate([
            'state.title' => 'required|string|max:255|unique:documents,title,' . $this->document?->id,
            'state.content' => 'required|string',
            'state.category_id' => 'required|exists:categories,id',
            'state.subcategory_id' => 'required|exists:sub_categories,id',
        ]);

        try {
            if ($this->document) {
                $this->document->update($this->state);

                $this->dispatch('toast', notify: 'success', title: 'Document', message: 'Document updated successfully.');

            } else {
                Document::create($this->state);

                $this->dispatch('toast', notify: 'success', title: 'Document', message: 'Document created successfully.');
                $this->reset('state');
                $this->dispatch('prefill-select2-document-form', selector: '#categoryList', id: '', text: '');

                $this->dispatch('prefill-select2-document-form', selector: '#subcategoryList', id: '', text: '');

                $this->dispatch('content-updated', text: '');
            }
            $this->resetValidation();

        } catch (\Exception $e) {
            $this->dispatch('toast', notify: 'error', title: 'Document', message: 'An error occurred: ' . $e->getMessage());
        }
    }
}
