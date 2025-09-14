<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="font-size:0.875em">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!--início::Metatags de acessibilidade-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--fim::Metatags de acessibilidade-->

    <!--início::Recursos de acessibilidade-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('css/adminlte.css') }}" as="style" />
    <!--fim::Recursos de acessibilidade-->

    <!--início::Fontes-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!--fim::Fontes-->

    <!--início::Plugin de terceiros (OverlayScrollbars)-->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/overlayScrollbars.min.css') }}"
        crossorigin="anonymous" />
    <!--fim::Plugin de terceiros (OverlayScrollbars)-->

    <!--início::Plugin de terceiros (Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--fim::Plugin de terceiros (Bootstrap Icons)-->

    <!--início::Plugin necessário (AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <!--fim::Plugin necessário (AdminLTE)-->

    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/select2-bootstrap-5-theme.min.css') }}" />
    <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs5.min.css')}}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->

    <style>
        .loader {
            position: absolute;
            top: 0px;
            right: 0px;
            width: 100%;
            height: 100%;
            background-color: #eceaea;
            background-size: 50px;
            background-repeat: no-repeat;
            background-position: center;
            z-index: 10000000;
            opacity: 0.4;
            filter: alpha(opacity=40);
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rfimered {
            line-height: normal !important;
            /* Remove o line-height */
            padding-left: 8px;
            /* Adiciona espaçamento */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px !important;
            top: 0;
            /* Remove qualquer deslocamento */
            display: flex;
            align-items: center;
        }

        .select2-selection__choice * {
            color: #000 !important;
        }

        .select2-selection__choice {
            color: #000 !important;
        }
    </style>

    @livewireStyles

    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--início::App Wrapper-->
    <div class="app-wrapper">
        <!--início::Header-->
        @livewire('layouts.top-nav-bar')
        <!--fim::Header-->
        <!--início::Sidebar-->
        @livewire('layouts.side-bar')
        <!--fim::Sidebar-->
        <!--início::App Principal-->
        <main class="app-main">
            {{ $slot ?? ''}}
            @yield('content')

            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="toastSuccess" class="toast toast-success" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="toast-header">
                        <i class="bi bi-circle me-2"></i>
                        <strong class="me-auto toast-title"></strong>
                        <small class="toast-time"></small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body"></div>
                </div>

                <div id="toastError" class="toast toast-danger" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="bi bi-circle me-2"></i>
                        <strong class="me-auto toast-title"></strong>
                        <small class="toast-time"></small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body"></div>
                </div>

                <div id="toastWarning" class="toast toast-warning" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="toast-header">
                        <i class="bi bi-circle me-2"></i>
                        <strong class="me-auto toast-title"></strong>
                        <small class="toast-time"></small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body"></div>
                </div>

                <div id="toastInfo" class="toast toast-info" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="bi bi-circle me-2"></i>
                        <strong class="me-auto toast-title"></strong>
                        <small class="toast-time"></small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body"></div>
                </div>
            </div>

        </main>
        <!--fim::App Principal-->
        <!--início::Footer-->
        <footer class="app-footer">
            <!--início::Até ao fim-->
            <div class="float-end d-none d-sm-inline"><b>Versão</b>
            </div>
            <!--fim::Até ao fim-->
            <!--início::Copyright-->
            <strong>Copyright &copy; {{ date('Y') }}; <a href="https://manuelluvuvamo.vercel.app">Manuel Luvuvamo</a></strong>
            <!--fim::Copyright-->
        </footer>
        <!--fim::Footer-->
    </div>
    <!--fim::App Wrapper-->
    <!--início::Script-->
    <!-- jQuery (uma única vez) -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}" crossorigin="anonymous"></script>

    <!-- Bootstrap 5 (apenas o BUNDLE, que já traz Popper) -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>

    <!-- OverlayScrollbars -->
    <script src="{{ asset('plugins/overlayscrollbars/js/overlayscrollbars.browser.es6.min.js') }}"
        crossorigin="anonymous"></script>

    <!-- AdminLTE (depois do Bootstrap) -->
    <script src="{{ asset('js/adminlte.js') }}"></script>

    <!-- Plugins que dependem de jQuery (depois do jQuery) -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/lang/summernote-pt-PT.min.js') }}"></script>
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>

    <!--início::OverlayScrollbars Configuração-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

            // Desative as barras de rolagem sobrepostas em dispositivos móveis para evitar interferências de toque
            const isMobile = window.innerWidth <= 992;

            if (
                sidebarWrapper &&
                OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
                !isMobile
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--fim::OverlayScrollbars Configuração-->

    <!--fim::Script-->

    @livewireScripts
    <script>
        $(document).ready(function () {
            document.addEventListener('toast', function (event) {

                let notify = event.detail.notify || 'info'; // success, danger, warning, info
                let message = event.detail.message || '';
                let title = event.detail.title || '';

                let toastEl = document.getElementById('toast' + notify.charAt(0).toUpperCase() + notify.slice(1));
                if (toastEl) {
                    // Actualiza o texto do corpo
                    toastEl.querySelector('.toast-title').textContent = title;
                    toastEl.querySelector('.toast-body').textContent = message;

                    // Cria/recupera a instância e exibe
                    let toast = bootstrap.Toast.getOrCreateInstance(toastEl);
                    toast.show();
                }
            });

            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));

        });
    </script>

    @stack('scripts')
</body>

</html>
