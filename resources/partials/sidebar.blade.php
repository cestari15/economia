<div id="sidebar-wrapper">
    <div class="brand-logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo-icon.png') }}" class="logo-icon" alt="logo">
            <h5 class="logo-text">Economizz</h5>
        </a>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-header">NAVEGAÇÃO PRINCIPAL</li>
        <li>
            <a href="{{ route('home') }}">
                <i class="bi bi-speedometer2"></i> <span>HOME</span>
            </a>
        </li>
        <li>
            <a href="{{ route('formulario') }}">
                <i class="bi bi-card-list"></i> <span>Formulários</span>
            </a>
        </li>
        <li>
            <a href="{{ route('calendario') }}">
                <i class="bi bi-calendar-check"></i> <span>Calendário</span>
            </a>
        </li>
        <li>
            <a href="{{ route('profile') }}">
                <i class="bi bi-person"></i> <span>Perfil</span>
            </a>
        </li>
    </ul>
</div>
