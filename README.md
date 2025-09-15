# :Português: [Leia este README em Português](./README.pt-br.md)

# Laravel Livewire Select2 Integration

> **This example uses Laravel 12.**

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18
- NPM
- SQLite (or other database)
- Laravel 12

This repository demonstrates a simple and robust way to use the Select2 jQuery plugin with Laravel Livewire, solving common issues developers face when integrating dynamic select fields in Livewire components.

## Why This Script?

Many developers struggle to make Select2 work seamlessly with Livewire due to DOM re-renders and state synchronization. This script provides a clean solution, allowing you to use Select2 in your Livewire forms without headaches.

## Features

- Plug-and-play Select2 initialization for Livewire forms
- Dynamic AJAX loading with dependencies (e.g., subcategories based on category)
- Automatic value prefill and state sync between Select2 and Livewire


## How It Works


The script leverages custom data attributes and Livewire events to:

- Initialize Select2 fields after every Livewire update
- Sync Select2 values with Livewire properties
- Prefill Select2 fields when editing existing records
- Handle dependent selects (e.g., subcategory depends on category)

### About the data-attributes

Each Select2 field uses a set of `data-` attributes to control its behavior and integration with Livewire:

- `data-init-select2-document-form`: Used as a selector for initializing Select2 on the field. **It is highly recommended to use a unique value per form/page/modal, e.g., `data-init-select2-myform`**, to avoid JavaScript conflicts, especially when using multiple forms or modals on the same page.
- `data-livewire-prop`: The Livewire property that will be updated when the select value changes (e.g., `state.category_id`).
- `data-placeholder`: The placeholder text shown in the select.
- `data-min-length`: Minimum number of characters before triggering the AJAX search.
- `data-api-url`: The API endpoint for AJAX loading of options.
- `data-per-page`: Number of results per page for AJAX requests.
- `data-dep-selector`: (Optional) jQuery selector for a dependent field (e.g., subcategory depends on category).
- `data-dep-param`: (Optional) The parameter name sent to the API for the dependent value (e.g., `category_id`).

**Example of customizing the selector:**

```blade
<select data-init-select2-myform ...>
```

Update your initialization script and selectors accordingly to match your custom attribute.

## Usage


### 1. Add Select2 Fields in Your Blade View

```blade
<select id="categoryList" data-width="100%"
	class="form-select categoryList"
	data-init-select2-myform
	data-livewire-prop="state.category_id"
	data-placeholder="Select the Category"
	data-min-length="3"
	data-api-url="{{ route('api.category.index') }}"
	data-per-page="20" required>
	<option value="">Select the Category</option>
</select>

<select id="subcategoryList" data-width="100%"
	class="form-select subcategoryList"
	data-init-select2-myform
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

Add the following script to your Blade view (usually via `@push('scripts')`). This script:

- Initializes Select2 on all fields with your custom `data-init-select2-*` attribute
- Handles AJAX loading, dependencies, and Livewire property sync
- Listens for Livewire and custom events to re-initialize or prefill fields

```blade
@push('scripts')
	<script>
		(() => {
			const DEFAULT_SELECT2_OPTIONS = {
				theme: 'bootstrap-5',
				language: 'pt',
				placeholder: 'Selecione',
				allowClear: true,
				minimumInputLength: 0
			};

			function initializeSelect2($select) {
				if (!$select.length) return;
				if ($select.hasClass('select2-hidden-accessible')) $select.select2('destroy');

				const options = {
					...DEFAULT_SELECT2_OPTIONS
				};

				const apiUrl = $select.data('api-url');
				if (apiUrl) {
					const perPage = Number($select.data('per-page')) || 20;
					const depSelector = $select.data('dep-selector') || $select.data('depSelector');
					const depParam = $select.data('dep-param') || $select.data('depParam') || 'prop_id';

					if (depSelector && depParam) {
						options.ajax = {
							url: apiUrl,
							dataType: 'json',
							delay: 250,
							data: params => {
								const payload = {
									term: params.term || '',
									page: params.page || 1,
									per_page: perPage,
								};

								if (depSelector) {
									const depVal = $(depSelector).val();
									if (depVal !== undefined && depVal !== null && depVal !== '') {
										payload[depParam] = depVal;
									}
								}
								return payload;

							}

						};

					} else {

						options.ajax = {

							url: apiUrl,
							dataType: 'json',
							delay: 250,
							data: params => ({
								term: params.term || '',
								page: params.page || 1,
								per_page: perPage
							})
						}
					}
				}

				if ($select.data('placeholder') !== undefined) options.placeholder = $select.data('placeholder');
				if ($select.data('min-length') !== undefined) options.minimumInputLength = Number($select.data(
					'min-length'));

				$select.select2(options);

				$(document).off('select2:open.s2min').on('select2:open.s2min', () => {
					document.querySelector('.select2-search__field')?.focus();
				});

				const livewireProp = $select.data('livewire-prop');
				if (livewireProp) $select.off('change.s2min').on('change.s2min', function() {
					@this.set(livewireProp, $(this).val());
				});
			}

			function scanForSelect2(context = document) {
				$('[data-init-select2-document-form]', context).each(function() {
					initializeSelect2($(this));
				});
			}

			document.addEventListener('DOMContentLoaded', () => scanForSelect2());
			document.addEventListener('livewire:load', () => {
				Livewire.hook('message.processed', () => scanForSelect2());
			});

			window.initSelect2 = scanForSelect2;
			window.initializeSelect2DocumentForm = initializeSelect2;

			$('#categoryList').on('change', () => {
				$('#subcategoryList').val(null).trigger('change');
			});
		})();
	</script>

	<script>
		window.addEventListener('prefill-select2-document-form', (e) => {
			setTimeout(() => {
				const {
					selector,
					id,
					text
				} = e.detail || {};
				if (!selector || id == null) return;
				const $el = $(selector);

				if ($el.find("option[value='" + id + "']").length === 0) {
					var newOption = new Option(text, id, true, true);
					$el.append(newOption).trigger('change');
				} else {
					$el.val(id).trigger('change');
				}
			}, 100);
		});
	</script>
@endpush
```

### 3. Livewire Component Integration


In your Livewire component (e.g., `DocumentForm`):

- Use `$this->dispatch('prefill-select2-document-form', ...)` to prefill values when editing

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

	// ...
}
```

## Running the Example Project

1. **Clone the repository:**
   ```bash
   git clone https://github.com/manuelluvuvamo/laravel-livewire-select2
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

4. **Start the project:**
	```bash
	composer run dev
	```

5. **Access the app:**
   - Open your browser at [http://localhost:8000](http://localhost:8000)

## Exploring the Example

- Try creating and editing documents using the form.
- The Category and SubCategory fields use Select2 with AJAX and dependency.
- All select fields are fully synchronized with Livewire state.

## Customization

- You can adapt the script for other Select2 fields by following the same data attribute conventions.
- For more complex dependencies, adjust the JavaScript as needed.

## License

MIT
