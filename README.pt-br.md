
# Integração Laravel Livewire Select2

Este repositório demonstra uma forma simples e robusta de usar o plugin Select2 jQuery com Laravel Livewire, resolvendo problemas comuns enfrentados por desenvolvedores ao integrar campos select dinâmicos em componentes Livewire.

## Por que este script?

Muitos desenvolvedores têm dificuldade em fazer o Select2 funcionar perfeitamente com o Livewire devido a re-renderizações do DOM e sincronização de estado. Este script oferece uma solução limpa, permitindo que você use o Select2 em seus formulários Livewire sem dores de cabeça.

## Funcionalidades

- Inicialização plug-and-play do Select2 para formulários Livewire
- Carregamento AJAX dinâmico com dependências (ex: subcategorias baseadas na categoria)
- Preenchimento automático e sincronização de valores entre Select2 e Livewire

## Como funciona

O script utiliza atributos personalizados `data-` e eventos do Livewire para:

- Inicializar campos Select2 após cada atualização do Livewire
- Sincronizar valores do Select2 com propriedades do Livewire
- Preencher campos Select2 ao editar registros existentes
- Lidar com selects dependentes (ex: subcategoria depende da categoria)

### Sobre os data-attributes

Cada campo Select2 utiliza um conjunto de atributos `data-` para controlar seu comportamento e integração com o Livewire:

- `data-init-select2-document-form`: Usado como seletor para inicializar o Select2 no campo. **É altamente recomendável usar um valor único por formulário/página/modal, ex: `data-init-select2-meuform`**, para evitar conflitos de JavaScript, especialmente ao usar múltiplos formulários ou modais na mesma página.
- `data-livewire-prop`: A propriedade do Livewire que será atualizada quando o valor do select mudar (ex: `state.category_id`).
- `data-placeholder`: O texto do placeholder exibido no select.
- `data-min-length`: Número mínimo de caracteres antes de disparar a busca AJAX.
- `data-api-url`: Endpoint da API para carregamento AJAX das opções.
- `data-per-page`: Número de resultados por página para requisições AJAX.
- `data-dep-selector`: (Opcional) Seletor jQuery para um campo dependente (ex: subcategoria depende da categoria).
- `data-dep-param`: (Opcional) Nome do parâmetro enviado para a API com o valor dependente (ex: `category_id`).

**Exemplo de personalização do seletor:**

```blade
<select data-init-select2-meuform ...>
```

Atualize seu script de inicialização e seletores conforme necessário para corresponder ao seu atributo personalizado.

## Como usar

### 1. Adicione os campos Select2 na sua Blade View

```blade
<select id="categoryList" data-width="100%"
	class="form-select categoryList"
	data-init-select2-meuform
	data-livewire-prop="state.category_id"
	data-placeholder="Selecione a Categoria"
	data-min-length="3"
	data-api-url="{{ route('api.category.index') }}"
	data-per-page="20" required>
	<option value="">Selecione a Categoria</option>
</select>

<select id="subcategoryList" data-width="100%"
	class="form-select subcategoryList"
	data-init-select2-meuform
	data-livewire-prop="state.subcategory_id"
	data-placeholder="Selecione a Subcategoria"
	data-min-length="0"
	data-api-url="{{ route('api.subcategory.index') }}"
	data-dep-selector="#categoryList"
	data-dep-param="category_id"
	data-per-page="20" required>
	<option value="">Selecione a Subcategoria</option>
</select>
```


### 2. Inclua o JavaScript

Adicione o seguinte script à sua view Blade (geralmente via `@push('scripts')`). Este script:

- Inicializa o Select2 em todos os campos com seu atributo personalizado `data-init-select2-*`
- Gerencia carregamento AJAX, dependências e sincronização com o Livewire
- Escuta eventos do Livewire e eventos customizados para reinicializar ou preencher campos

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

### 3. Integração no componente Livewire

No seu componente Livewire (ex: `DocumentForm`):

- Use `$this->dispatch('prefill-select2-document-form', ...)` para preencher valores ao editar

Exemplo:

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

## Executando o projeto de exemplo

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/manuelluvuvamo/laravel-livewire-select2
   cd laravel-livewire-select2
   ```

2. **Instale as dependências:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configure o ambiente:**
   - Copie `.env.example` para `.env` e configure seu banco de dados (SQLite já está pré-configurado).
   - Rode as migrations e seeders:
	 ```bash
	 php artisan migrate --seed
	 ```


4. **Inicie o projeto:**
	```bash
	composer run dev
	```

5. **Acesse o app:**
   - Abra seu navegador em [http://localhost:8000](http://localhost:8000)

## Explorando o exemplo

- Tente criar e editar documentos usando o formulário.
- Os campos Categoria e Subcategoria usam Select2 com AJAX e dependência.
- Todos os campos select estão totalmente sincronizados com o estado do Livewire.

## Customização

- Você pode adaptar o script para outros campos Select2 seguindo as mesmas convenções de data-attributes.
- Para dependências mais complexas, ajuste o JavaScript conforme necessário.

## Licença

MIT
