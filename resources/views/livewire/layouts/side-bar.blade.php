<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--início::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--início::Brand Link-->
        <a href="{{ url('/') }}" class="brand-link">
            <!--início::Brand Image-->
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image opacity-75 shadow" />
            <!--fim::Brand Image-->
            <!--início::Brand Text-->
            <span class="brand-text fw-light">Select 2 Descomplicado</span>
            <!--fim::Brand Text-->
        </a>
        <!--fim::Brand Link-->
    </div>
    <!--fim::Sidebar Brand-->
    <!--início::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--início::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">

                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="nav-icon bi bi-house"></i>
                        <p>Home</p>
                    </a>
                </li>

                <li class="nav-header">DOCUMENTTS</li>

                <li class="nav-item">
                    <a href="{{ route('category.index') }}"
                        class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Categories</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('subcategory.index') }}"
                        class="nav-link {{ request()->routeIs('subcategory.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Subcategories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('document.index') }}"
                        class="nav-link {{ request()->routeIs('document.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Documents</p>
                    </a>
                </li>

               
            </ul>
            <!--fim::Sidebar Menu-->
        </nav>
    </div>
    <!--fim::Sidebar Wrapper-->
</aside>
