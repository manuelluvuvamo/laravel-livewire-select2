<nav class="app-header navbar navbar-expand bg-body">
    <!--início::Container-->
    <div class="container-fluid">
        <!--início::Iniciar Links da barra de navegação-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>

        </ul>
        <!--fim::Iniciar Links da barra de navegação-->

        <!--início::Fim Links da barra de navegação-->
        <ul class="navbar-nav ms-auto">
            <!--início::Pesquisa na barra de navegação-->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <!--fim::Pesquisa na barra de navegação-->


            <!--início::Alternar para ecrã inteiro-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--fim::Alternar para ecrã inteiro-->
            <!--início::Menu suspenso do utilizador-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/avatar.png') }}" class="user-image rounded-circle shadow"
                        alt="Imagem do utilizador" />
                    <span class="d-none d-md-inline">John Doe</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--início::Imagem do utilizador-->
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('assets/img/avatar.png') }}" class="rounded-circle shadow"
                            alt="Imagem do utilizador" />
                        <p>
                            John Doe
                        </p>
                    </li>
                    <!--fim::Imagem do utilizador-->

                    <!--início::Rodapé do menu-->
                    <li class="user-footer">

                        <button type="submit" class="btn btn-default btn-flat float-end">Sair</button>
                    </li>
                    <!--fim::Rodapé do menu-->
                </ul>
            </li>
            <!--fim::Menu suspenso do utilizador-->
        </ul>
        <!--fim::Links da barra de navegação-->
    </div>
    <!--fim::Container-->
</nav>
