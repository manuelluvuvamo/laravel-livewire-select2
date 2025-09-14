<div>
    <!--início::Cabeçalho do conteúdo da app-->
    <div class="app-content-header">
        <!--início::Container-->
        <div class="container-fluid">
            <!--início::Row-->
            <div class="row callout callout-success">
                <div class="col-sm-6">
                    <h3 class="mb-0">Categories</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
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


                        <!-- Card Header -->
                        <div class="card-header d-flex flex-wrap align-items-center gap-2">
                            <div class="badge bg-primary px-3 py-2 rounded-pill">
                                <h3 class="card-title mb-0">
                                    <a href="{{ route('category.index') }}" class="text-white text-decoration-none">
                                        <i class="fa fa-clipboard-list me-2"></i>Categories
                                    </a>
                                </h3>
                            </div>
                            <div class="flex-grow-1"></div>
                            <div class="ms-auto" style="min-width:300px;">
                                <div class="input-group input-group-sm justify-content-end">
                                    <a class="btn btn-success ms-2 mt-1 mt-sm-0" href="{{ route('category.create') }}"
                                        wire:loading.class="disabled">
                                        <i class="fa fa-plus-circle me-1"></i> New Category
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
                                            <th style="width: 10%">#</th>
                                            <th style="width: 70%">Name</th>
                                            <th style="width: 20%" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @forelse ($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>

                                                <td>{{ $category->name }}</td>

                                                <td class="text-center" style="width: 8%">
                                                    <div class="btn-group">
                                                        <a href="{{ route('category.edit', $category->id) }}"
                                                            wire:loading.class="disabled" class="btn btn-warning btn-sm me-1"
                                                            data-bs-toggle="tooltip" title="Edit Category">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        <a href="#"
                                                            wire:click.prevent="delete({{ $category->id }})"
                                                            wire:confirm="Are you sure that you want to delete this category?"
                                                            wire:loading.class="disabled" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="tooltip" title="Delete Category">
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
                                {{ $categories->links() }}
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
