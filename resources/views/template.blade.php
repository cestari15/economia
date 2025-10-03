<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Painel de Controle')</title>

    <!-- CSS Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar-menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-style.css') }}" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="bg-theme bg-theme1">

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="brand-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" class="logo-icon" alt="logo">
                    <h5 class="logo-text">Economizz</h5>
                </a>
            </div>
            <ul class="sidebar-menu" id="sidebar-menu">
                <li class="sidebar-header">NAVEGAÇÃO PRINCIPAL</li>
                <li><a href="{{ route('home') }}"><i class="icon-speedometer"></i> <span>Home</span></a></li>
                <li><a href="{{ route('calendario') }}"><i class="icon-calendar"></i> <span>Calendário</span></a></li>
                <li><a href="{{ route('anotacoes') }}"><i class="icon-note"></i> <span>Anotações</span></a></li>

                @if (session('token'))
                    @php
                        $user = json_decode(session('user') ?? '{}');
                    @endphp

                    @if (isset($user->tipo) && $user->tipo === 'admin')
                        <li><a href="{{ route('listagem-clientes') }}"><i class="icon-people"></i> <span>Listagem de
                                    Clientes</span></a></li>
                    @endif
                @endif

                <li><a href="{{ route('profile') }}"><i class="icon-user"></i> <span>Perfil</span></a></li>
                @if (!session('token'))
                    <li><a href="{{ route('login') }}"><i class="icon-login"></i> <span>Login</span></a></li>
                @endif
            </ul>

        </div>

        <!-- Topbar -->
        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top">
                <ul class="navbar-nav mr-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link toggle-menu" href="#"><i class="icon-menu"></i></a>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center right-nav-link">
                    <li class="nav-item d-flex align-items-center" id="topbar-user" style="display:none;">
                        <img src="{{ asset('images/logo.png') }}" alt="avatar" class="rounded-circle me-2"
                            width="35">
                        <span id="user-name" class="me-3">Carregando...</span>
                        <button class="btn btn-danger btn-sm" id="logout-btn"><i class="icon-logout"></i>
                            Logout</button>
                    </li>
                </ul>
            </nav>
        </header>

        <!-- Conteúdo principal -->
        <div class="content-wrapper">
            <div class="container-fluid">
                @yield('conteudo')
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container text-center text-white">
                Copyright © CestariDEV
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('js/app-script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Toggle sidebar
            $('.toggle-menu').click(function() {
                $('#wrapper').toggleClass('toggled');
            });

            const user = JSON.parse(localStorage.getItem('user'));
            const token = localStorage.getItem('token');

            if (user && token) {
                // Mostrar topbar e nome do usuário
                $('#topbar-user').show();
                $('#user-name').text(user.nome || user.name);
                $('#link-login').hide();

                // Mostrar link listagem de clientes só para admin
                if (user.tipo === 'admin') {
                    $('#link-listagem-clientes').show();

                    // SweetAlert de login do admin
                    Swal.fire({
                        icon: 'success',
                        title: 'Admin logado!',
                        text: 'Bem-vindo, ' + (user.nome || user.name)
                    });
                }

                // Logout
                $('#logout-btn').click(function() {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    window.location.href = '{{ route('login') }}';
                });
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
