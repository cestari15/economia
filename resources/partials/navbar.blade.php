<!-- Sidebar -->
<div id="sidebar-wrapper">
    <div class="brand-logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo-icon.png') }}" class="logo-icon" alt="logo">
            <h5 class="logo-text">Economizz</h5>
        </a>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-header">NAVEGAÇÃO PRINCIPAL</li>
        <li><a href="{{ route('home') }}"><i class="bi bi-speedometer2"></i> <span>HOME</span></a></li>
        <li><a href="{{ route('formulario') }}"><i class="bi bi-card-list"></i> <span>Formulários</span></a></li>
        <li><a href="{{ route('calendario') }}"><i class="bi bi-calendar-check"></i> <span>Calendário</span></a></li>
        <li><a href="{{ route('profile') }}"><i class="bi bi-person"></i> <span>Perfil</span></a></li>
    </ul>
</div>
<!-- Fim Sidebar -->

<!-- Topbar -->
<header class="topbar-nav">
    <nav class="navbar navbar-expand fixed-top">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav align-items-center right-nav-link">
            <li class="nav-item">
                <a class="nav-link" href="javascript:void();">
                    <i class="fa fa-envelope-open-o"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void();">
                    <i class="fa fa-bell-o"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                    <img id="user-avatar-dropdown" src="https://via.placeholder.com/110x110" class="rounded-circle" width="35" alt="avatar">
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item user-details">
                        <div class="media">
                            <img id="user-avatar" src="https://via.placeholder.com/110x110" alt="avatar" class="align-self-start mr-3 rounded-circle" width="60">
                            <div class="media-body">
                                <h6 class="mt-2" id="user-name">Carregando...</h6>
                                <p class="user-subtitle" id="user-email"></p>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <i class="icon-power mr-2"></i> <a href="{{ route('logout') }}">Sair</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<!-- Fim Topbar -->
