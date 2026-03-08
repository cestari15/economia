<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRONOS - Controle de Gastos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

   <style>
        :root {
            --azul-deep: #001529;
            --azul-vibrante: #2563eb;
            --azul-claro: #3b82f6;
            --azul-botao: #00d4ff;
            --branco: #ffffff;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* HEADER & NAVBAR */
        header {
            background: var(--azul-deep);
            padding: 1rem 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: contain;
        }

        .logo-text {
            color: white;
            font-size: 1.4rem;
            font-weight: bold;
        }

        .logo-text span {
            color: var(--azul-botao);
        }

        nav {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        nav a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        nav a:hover {
            color: white;
        }

        .btn-white {
            background: white;
            color: var(--azul-deep);
            padding: 8px 25px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            border: 2px solid white;
            transition: 0.3s;
        }

        .btn-white:hover {
            background: transparent;
            color: white;
            border-color: white;
        }

        .btn-cyan {
            background: var(--azul-botao);
            color: var(--azul-deep);
            padding: 8px 25px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            border: 2px solid var(--azul-botao);
            transition: 0.3s;
        }

        .btn-cyan:hover {
            background: transparent;
            color: var(--azul-botao);
            border-color: var(--azul-botao);
        }

        /* HERO SECTION */
        .hero {
            background: linear-gradient(180deg, var(--azul-vibrante) 0%, var(--azul-claro) 100%);
            padding: 80px 10% 160px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .hero-content {
            max-width: 50%;
        }

        .hero h1 {
            font-size: 3.2rem;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 35px;
            line-height: 1.6;
        }

        .hero-image img {
            width: 100%;
            max-width: 550px;
            filter: drop-shadow(0 20px 50px rgba(0, 0, 0, 0.2));
        }

        /* CARDS FLUTUANTES */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 0 10%;
            margin-top: -100px;
        }

        .feature-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-card i {
            font-size: 2.5rem;
            color: var(--azul-vibrante);
            margin-bottom: 20px;
            display: block;
        }

        .feature-card h3 {
            color: var(--azul-deep);
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .feature-card p {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* SEÇÃO SOBRE */
        .about-section {
            padding: 120px 10%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            background: white;
        }

        .about-text {
            max-width: 50%;
        }

        .about-text h2 {
            font-size: 2.5rem;
            color: var(--azul-deep);
            margin-bottom: 20px;
        }

        .about-text p {
            font-size: 1.1rem;
            color: #475569;
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .targets {
            margin-top: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .target-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: var(--azul-vibrante);
        }

        .about-img img {
            width: 100%;
            max-width: 500px;
        }

        /* FOOTER */
        .footer {
            background: var(--azul-deep);
            color: white;
            text-align: center;
            padding: 60px 10%;
        }

        .footer-logo {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .footer-logo span {
            color: var(--azul-botao);
        }

        /* RESPONSIVIDADE */
        @media (max-width: 992px) {
            .hero, .about-section {
                flex-direction: column;
                text-align: center;
                padding: 60px 5%;
            }

            .hero-content, .about-text {
                max-width: 100%;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .features {
                margin-top: -50px;
                padding: 0 5%;
            }
        }
   </style>
</head>

<body>

    <header>
        <a href="/" class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            <div class="logo-text">CRO<span>NOS</span></div>
        </a>
        <nav>
            <a href="{{ route('servicos') }}">Serviços</a>
            <a href="{{ route('sobre') }}">Sobre</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-cyan">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-white">Entrar</a>
                    <a href="{{ route('register') }}" class="btn-cyan">Cadastrar</a>
                @endauth
            @endif
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Organização financeira para o seu lar</h1>
                <p>
                    O <strong>CRONOS</strong> é a ferramenta ideal para quem quer assumir o comando.
                    Registre gastos, analise dados e planeje o futuro com confiança.
                </p>
                <a href="{{ route('register') }}" class="btn-white"
                    style="padding: 15px 40px; font-size: 1.1rem; text-decoration: none; border-radius: 50px; font-weight: bold; display: inline-block;">
                    Comece a ganhar tempo – Grátis
                </a>
            </div>

            <div class="hero-image">
                <img src="{{ asset('images/Personal.svg') }}" alt="Controle financeiro"
                    style="width: 450px; max-width: 100%;">
            </div>
        </section>

        <section class="features" id="servicos">
            <div class="feature-card">
                <i class="fas fa-stopwatch"></i>
                <h3>Registo Eficiente</h3>
                <p>Cada minuto que você economiza aqui é um minuto a mais de liberdade no seu futuro.</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-business-time"></i>
                <h3>Relatórios Cronológicos</h3>
                <p>Dinheiro gasto hoje é tempo de vida investido. Visualize o ciclo do seu capital com precisão.</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-vault"></i>
                <h3>Segurança de Longo Prazo</h3>
                <p>Protegemos o seu patrimônio para que você possa focar no que realmente importa: o seu tempo.</p>
            </div>
        </section>

        <section class="about-section" id="sobre">
            <div class="about-text">
                <h2>Feito para a sua família</h2>
                <p>
                    Partilhe o planeamento com quem mais importa. Com o CRONOS,
                    todos em casa podem entender a saúde financeira da família.
                </p>

                <div class="targets"
                    style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px;">

                    <div class="target-item"
                        style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #2563eb;">
                        <i class="fas fa-check-circle"></i> Pais e Mães
                    </div>

                    <div class="target-item"
                        style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #2563eb;">
                        <i class="fas fa-check-circle"></i> Jovens Adultos
                    </div>

                    <div class="target-item"
                        style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #2563eb;">
                        <i class="fas fa-check-circle"></i> Gestores do Lar
                    </div>

                    <div class="target-item"
                        style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #2563eb;">
                        <i class="fas fa-check-circle"></i> Planeadores
                    </div>
                </div>
            </div>

            <div class="about-img">
                <img src="{{ asset('images/familia.svg') }}" alt="Familia" style="width: 450px; max-width: 100%;">
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="footer-logo">CRO<span>NOS</span></div>
        <p>A sua paz financeira começa com a gestão do seu tempo.</p>
        <p style="margin-top: 20px; opacity: 0.4;">&copy; {{ date('Y') }} CRONOS. Desenvolvido com Laravel e
            MySQL.</p>
    </footer>

</body>
</html>