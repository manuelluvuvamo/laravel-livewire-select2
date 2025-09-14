# Laravel Livewire Select2 Integration

This repository demonstrates a simple and robust way to use the Select2 jQuery plugin with Laravel Livewire, solving common issues developers face when integrating dynamic select fields in Livewire components.

## Why This Script?

Many developers struggle to make Select2 work seamlessly with Livewire due to DOM re-renders and state synchronization. This script provides a clean solution, allowing you to use Select2 in your Livewire forms without headaches.

## Features

- Plug-and-play Select2 initialization for Livewire forms
- Dynamic AJAX loading with dependencies (e.g., subcategories based on category)
- Automatic value prefill and state sync between Select2 and Livewire
- Summernote integration for rich text editing

## How It Works

The script leverages custom data attributes and Livewire events to:

- Initialize Select2 fields after every Livewire update
- Sync Select2 values with Livewire properties
- Prefill Select2 fields when editing existing records
- Handle dependent selects (e.g., subcategory depends on category)
- Integrate with Summernote for content editing

## Usage

### 1. Add Select2 Fields in Your Blade View

```blade
<select id="categoryList" data-width="100%"
	class="form-select categoryList"
	data-init-select2-document-form
	data-livewire-prop="state.category_id"
	data-placeholder="Select the Category"
	data-min-length="3"
	data-api-url="{{ route('api.category.index') }}"
	data-per-page="20" required>
	<option value="">Select the Category</option>
</select>

<select id="subcategoryList" data-width="100%"
	class="form-select subcategoryList"
	data-init-select2-document-form
	data-livewire-prop="state.subcategory_id"
	data-placeholder="Select the SubCategory"
	data-min-length="0"
	data-api-url="{{ route('api.subcategory.index') }}"
	data-dep-selector="#categoryList"
	data-dep-param="category_id"
	data-per-page="20" required>
	<option value="">Select the SubCategory</option>
</select>
```

### 2. Include the JavaScript

Add the provided script to your Blade view (usually via `@push('scripts')`). This script:

- Initializes Select2 on all fields with `data-init-select2-document-form`
- Handles AJAX loading, dependencies, and Livewire property sync
- Listens for Livewire and custom events to re-initialize or prefill fields

### 3. Livewire Component Integration

In your Livewire component (e.g., `DocumentForm`):

- Use `$this->dispatch('prefill-select2-document-form', ...)` to prefill values when editing
- Use `$this->dispatch('init-summernote')` and `$this->dispatch('content-updated', ...)` for Summernote integration

Example:

```php
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
```

## Running the Example Project

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/laravel-livewire-select2.git
   cd laravel-livewire-select2
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Set up the environment:**
   - Copy `.env.example` to `.env` and configure your database (SQLite is pre-configured).
   - Run migrations and seeders:
	 ```bash
	 php artisan migrate --seed
	 ```

4. **Serve the application:**
   ```bash
   php artisan serve
   ```

5. **Access the app:**
   - Open your browser at [http://localhost:8000](http://localhost:8000)

## Exploring the Example

- Try creating and editing documents using the form.
- The Category and SubCategory fields use Select2 with AJAX and dependency.
- The content field uses Summernote for rich text editing.
- All select fields are fully synchronized with Livewire state.

## Customization

- You can adapt the script for other Select2 fields by following the same data attribute conventions.
- For more complex dependencies, adjust the JavaScript as needed.

## License

MIT
