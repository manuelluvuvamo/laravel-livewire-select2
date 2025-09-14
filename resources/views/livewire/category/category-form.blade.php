<div>
    <!--início::Cabeçalho do conteúdo da app-->
    <div class="app-content-header">
        <!--início::Container-->
        <div class="container-fluid">
            <!--início::Row-->
            <div class="row callout callout-success">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $category ? 'Update Category' : 'New Category' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $category ? 'Update Category' : 'New Category' }}
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

                                    <div class="card  {{ $category ? 'card-warning' : 'card-primary' }}  mb-0">
                                        <div class="card-header">
                                            <h3 class="card-title mb-0">
                                                <i class="fas fa-copy me-1"></i>
                                                {{ $category ? 'Update Category' : 'New Category' }}
                                            </h3>
                                        </div>

                                        <div class="card-body">
                                            <div class="row g-3">

                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            Name
                                                        </span>
                                                        <input type="text" id="name" placeholder="The name of the category"
                                                            class="form-control @error('state.name') is-invalid @enderror"
                                                            wire:model="state.name" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="float-end">
                                                <button type="submit" wire:loading.remove wire:target="save"
                                                    class="btn {{ $category ? 'btn-warning' : 'btn-primary' }}">
                                                    <i class="fa fa-check-circle me-1"></i>
                                                    <span>{{ $category ? 'Update' : 'Create' }}</span>
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
