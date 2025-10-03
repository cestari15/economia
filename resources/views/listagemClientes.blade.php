<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Painel de Controle')</title>

    <!-- CSS Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Simple Line Icons -->
    <link rel="stylesheet" href="{{ asset('css/simple-line-icons.min.css') }}">

    <!-- CSS do projeto -->
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
                <li><a href="{{ route('profile') }}"><i class="icon-user"></i> <span>Perfil</span></a></li>
                <li id="link-listagem-clientes" style="display:none;">
                    <a href="{{ route('listagem-clientes') }}"><i class="icon-people"></i> <span>Usuários</span></a>
                </li>
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
                    <li class="nav-item d-flex align-items-center" id="user-info" style="display:none;">
                        <img src="{{ asset('images/logo.png') }}" alt="avatar" class="rounded-circle me-2" width="35" id="user-avatar">
                        <span id="user-name" class="me-3"></span>
                        <button type="button" class="btn btn-danger btn-sm" id="logout-btn">
                            <i class="icon-logout"></i> Logout
                        </button>
                    </li>
                    <li class="nav-item" id="link-login">
                        <a class="nav-link" href="{{ route('login') }}"><i class="icon-login"></i> Login</a>
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

            const token = localStorage.getItem('token');
            if (token) {
                // Carrega dados do usuário
                fetch('{{ url("api/user") }}', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(user => {
                    $('#user-name').text(user.nome || user.name);
                    $('#user-info').show();
                    $('#link-login').hide();

                    // Se for admin, mostra link de listagem de usuários
                    if(user.tipo === 'admin'){
                        $('#link-listagem-clientes').show();
                        Swal.fire({
                            icon: 'success',
                            title: 'Admin logado!',
                            text: `Bem-vindo, ${user.nome}`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(() => {
                    Swal.fire('Erro', 'Não foi possível carregar os dados do usuário.', 'error');
                });

                // Logout
                $('#logout-btn').click(function() {
                    fetch('{{ url("logout") }}', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).finally(() => {
                        localStorage.removeItem('token');
                        window.location.href = '{{ route("login") }}';
                    });
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
