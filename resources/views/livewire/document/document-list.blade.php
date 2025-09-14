<div>
    <!--início::Cabeçalho do conteúdo da app-->
    <div class="app-content-header">
        <!--início::Container-->
        <div class="container-fluid">
            <!--início::Row-->
            <div class="row callout callout-success">
                <div class="col-sm-6">
                    <h3 class="mb-0">Documents</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Documents</li>
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
                        <!-- Loader -->
                        <div class="loader" wire:loading>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <div class="spinner-border text-primary" role="status" aria-live="polite"
                                    aria-busy="true">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>


                        @if (session()->has('error'))
                            <div class="alert bg-gradient-danger alert-dismissible fade show" role="alert">
                                <span>{{ session()->get('error') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Fechar"></button>
                            </div>
                        @endif

                         <nav class="navbar navbar-expand navbar-dark bg-primary rounded-top px-3 py-2">
                            <ul class="navbar-nav">
                                <li class="nav-item me-2 d-none d-sm-inline-block">
                                    <div wire:ignore>
                                        <select id="categoryList" data-width="300px" style="width:300px; font-size:1em;"
                                            class="form-select categoryList @error('category_id') is-invalid @enderror"
                                            data-init-select2-document-list data-livewire-prop="category_id"
                                            data-placeholder="Select the category" data-min-length="0"
                                            data-api-url="{{ route('api.category.index') }}" data-per-page="20"
                                            aria-readonly="true">
                                            <option value="">Select the category</option>
                                        </select>
                                    </div>
                                </li>

                                <li class="nav-item me-2 d-none d-sm-inline-block">
                                    <div wire:ignore>
                                        <select id="subcategoryList" data-width="300px" style="width:300px; font-size:1em;"
                                            class="form-select subcategoryList @error('subcategory_id') is-invalid @enderror"
                                            data-init-select2-document-list data-livewire-prop="subcategory_id"
                                            data-placeholder="Select the subcategory" data-min-length="0"
                                            data-api-url="{{ route('api.subcategory.index') }}" data-dep-selector="#categoryList"
                                            data-dep-param="category_id" data-per-page="20"
                                            aria-readonly="true">
                                            <option value="">Select the subcategory</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </nav>

                        <!-- Card Header -->
                        <div class="card-header d-flex flex-wrap align-items-center gap-2">
                            <div class="badge bg-primary px-3 py-2 rounded-pill">
                                <h3 class="card-title mb-0">
                                    <a href="{{ route('document.index') }}" class="text-white text-decoration-none">
                                        <i class="fa fa-clipboard-list me-2"></i>Documents
                                    </a>
                                </h3>
                            </div>
                            <div class="flex-grow-1"></div>
                            <div class="ms-auto" style="min-width:300px;">
                                <div class="input-group input-group-sm justify-content-end">
                                    <a class="btn btn-success ms-2 mt-1 mt-sm-0" href="{{ route('document.create') }}"
                                        wire:loading.class="disabled">
                                        <i class="fa fa-plus-circle me-1"></i> New Document
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Tabela -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 25%">Title</th>
                                            <th style="width: 20%">Content</th>
                                            <th style="width: 20%">Category</th>
                                            <th style="width: 20%">Subcategory</th>
                                            <th style="width: 10%" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @forelse ($documents as $document)
                                            <tr>
                                                <td>{{ $document->id }}</td>
                                                <td>{{ $document->title }}</td>
                                                <td>{!! $document->content !!}</td>
                                                <td>{{ $document->category->name }}</td>
                                                <td>{{ $document->subcategory->name }}</td>

                                                <td class="text-center" style="width: 8%">
                                                    <div class="btn-group">
                                                        <a href="{{ route('document.edit', $document->id) }}"
                                                            wire:loading.class="disabled" class="btn btn-warning btn-sm me-1"
                                                            data-bs-toggle="tooltip" title="Edit Document">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        <a href="#"
                                                            wire:click.prevent="delete({{ $document->id }})"
                                                            wire:confirm="Are you sure that you want to delete this Document?"
                                                            wire:loading.class="disabled" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="tooltip" title="Delete Document">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No entries found</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-1 me-1 p-2">
                                {{ $documents->links() }}
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
            const DEFAULT_SELECT2_OPTIONS = { theme: 'bootstrap-5', language: 'pt', placeholder: 'Select', allowClear: true, minimumInputLength: 0 };

            function initializeSelect2($select) {
                if (!$select.length) return;
                if ($select.hasClass('select2-hidden-accessible')) $select.select2('destroy');

                const options = { ...DEFAULT_SELECT2_OPTIONS };

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

                            url: apiUrl, dataType: 'json', delay: 250, data: params => ({ term: params.term || '', page: params.page || 1, per_page: perPage }) 
                        }
                    }
                }

                if ($select.data('placeholder') !== undefined) options.placeholder = $select.data('placeholder');
                if ($select.data('min-length') !== undefined) options.minimumInputLength = Number($select.data('min-length'));

                $select.select2(options);

                $(document).off('select2:open.s2min').on('select2:open.s2min', () => {
                    document.querySelector('.select2-search__field')?.focus();
                });

                const livewireProp = $select.data('livewire-prop');
                if (livewireProp) $select.off('change.s2min').on('change.s2min', function () { @this.set(livewireProp, $(this).val()); });
            }

            function scanForSelect2(context = document) { $('[data-init-select2-document-list]', context).each(function () { initializeSelect2($(this)); }); }

            document.addEventListener('DOMContentLoaded', () => scanForSelect2());
            document.addEventListener('livewire:load', () => {
                Livewire.hook('message.processed', () => scanForSelect2());
            });

            window.initSelect2 = scanForSelect2;
            window.initializeSelect2SubcategoryList = initializeSelect2;

            $('#categoryList').on('change', () => { $('#subcategoryList').val(null).trigger('change'); });
        })();
    </script>
@endpush

