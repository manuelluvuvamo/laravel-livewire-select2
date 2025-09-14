<div>
    <!--início::Cabeçalho do conteúdo da app-->
    <div class="app-content-header">
        <!--início::Container-->
        <div class="container-fluid">
            <!--início::Row-->
            <div class="row callout callout-success">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $document ? 'Update Document' : 'New Document' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('document.index') }}">Documents</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $document ? 'Update Document' : 'New Document' }}
                        </li>
                    </ol>
                </div>
            </div>
            <!--fim::Row-->
        </div>
        <!--fim::Container-->
    </div>
    <div class="app-content">
        <!--início::Container-->
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline position-relative">

                        <div>
                            <x-error-message-for-form :errors="$errors" />

                            <div tabindex="-1">
                                <form wire:submit.prevent="save" autocomplete="off"
                                    onsubmit="this.querySelectorAll('button, a').forEach(el => el.setAttribute('disabled', true));">
                                    @csrf

                                    <div class="card  {{ $document ? 'card-warning' : 'card-primary' }}  mb-0">
                                        <div class="card-header">
                                            <h3 class="card-title mb-0">
                                                <i class="fas fa-copy me-1"></i>
                                                {{ $document ? 'Update Document' : 'New Document' }}
                                            </h3>
                                        </div>

                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Category</span>
                                                        <div class="flex-grow-1" wire:ignore>
                                                            <select id="categoryList" data-width="100%"
                                                                class="form-select categoryList @error('state.category_id') is-invalid @enderror"
                                                                data-init-select2-document-form
                                                                data-livewire-prop="state.category_id"
                                                                data-placeholder="Select the Category"
                                                                data-min-length="3"
                                                                data-api-url="{{ route('api.category.index') }}"
                                                                data-per-page="20" required>
                                                                <option value="">Select the Category
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">SubCategory</span>
                                                        <div class="flex-grow-1" wire:ignore>
                                                            <select id="subcategoryList" data-width="100%"
                                                                class="form-select subcategoryList @error('state.subcategory_id') is-invalid @enderror"
                                                                data-init-select2-document-form
                                                                data-livewire-prop="state.subcategory_id"
                                                                data-placeholder="Select the SubCategory"
                                                                data-min-length="0"
                                                                data-api-url="{{ route('api.subcategory.index') }}"
                                                                data-dep-selector="#categoryList"
                                                                data-dep-param="category_id" data-per-page="20"
                                                                required>
                                                                <option value="">Select the SubCategory
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            Title
                                                        </span>
                                                        <input type="text" id="title"
                                                            placeholder="The title of the document"
                                                            class="form-control @error('state.title') is-invalid @enderror"
                                                            wire:model="state.title" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="summernote" class="form-label">
                                                        <i class="fas fa-align-left me-2"></i> Content
                                                    </label>

                                                    <div wire:ignore>
                                                        <textarea id="summernote">
                                                            @if ($document)
                                                            {!! $state['content'] !!}
                                                            @endif
                                                        </textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="float-end">
                                                <button type="submit" wire:loading.remove wire:target="save"
                                                    class="btn {{ $document ? 'btn-warning' : 'btn-primary' }}">
                                                    <i class="fa fa-check-circle me-1"></i>
                                                    <span>{{ $document ? 'Update' : 'Create' }}</span>
                                                </button>

                                                <button class="btn btn-warning" type="button" disabled wire:loading
                                                    wire:target="save">
                                                    <span class="spinner-border spinner-border-sm align-middle"
                                                        role="status" aria-hidden="true"></span>
                                                    <span class="ms-1">Loading...</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!--fim::Container-->
    </div>
    <!--fim::App Content-->
</div>
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

    <script>
        $('#summernote').on('summernote.change', function(we, contents, $editable) {
            @this.set('state.content', contents);
        });

        window.addEventListener('init-summernote', (e) => {
            $('#summernote').summernote({
                height: 200,
                width: '100%',
                lang: 'pt-PT',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                ]
            });

        });
        window.addEventListener('content-updated', event => {
            setTimeout(() => {
                $('#summernote').summernote('code', event.detail.text);
            }, 100);
        });
    </script>
@endpush
