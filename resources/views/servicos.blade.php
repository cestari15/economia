<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - CRONOS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --azul-deep: #001529;
            --azul-vibrante: #2563eb;
            --azul-botao: #00d4ff;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background: #f8fafc;
            color: #1e293b;
        }

        header {
            background: var(--azul-deep);
            padding: 1rem 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-text {
            color: white;
            font-size: 1.4rem;
            font-weight: bold;
            text-decoration: none;
        }

        .logo-text span {
            color: var(--azul-botao);
        }

        .btn-back {
            color: white;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid var(--azul-botao);
            padding: 10px 20px;
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: var(--azul-botao);
            color: var(--azul-deep);
        }

        .services-hero {
            background: linear-gradient(135deg, var(--azul-deep) 0%, var(--azul-vibrante) 100%);
            color: white;
            padding: 80px 10%;
            text-align: center;
        }

        .services-hero h1 {
            font-size: 2.8rem;
            margin-bottom: 15px;
        }

        .services-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .container {
            padding: 60px 10%;
        }

        .service-detail {
            display: flex;
            align-items: center;
            gap: 50px;
            margin-bottom: 80px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .service-detail:nth-child(even) {
            flex-direction: row-reverse;
        }

        .service-text {
            flex: 1;
        }

        .service-text h2 {
            color: var(--azul-vibrante);
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .service-text p {
            line-height: 1.7;
            color: #64748b;
            font-size: 1.1rem;
        }

        .impact {
            display: block;
            margin-top: 15px;
            color: var(--azul-vibrante);
            font-weight: 600;
        }

        .service-icon {
            flex: 0 0 150px;
            height: 150px;
            background: #eff6ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--azul-vibrante);
        }

        footer {
            background: var(--azul-deep);
            color: white;
            text-align: center;
            padding: 40px;
        }
    </style>
</head>
<body>

<header>
    <a href="/" class="logo-text">CRO<span>NOS</span></a>
    <a href="/" class="btn-back"><i class="fas fa-arrow-left"></i> Voltar</a>
</header>

<section class="services-hero">
    <h1>Soluções em Gestão CRONOS</h1>
    <p>Otimize seu tempo e assuma o comando do seu capital.</p>
</section>

<div class="container">

    <div class="service-detail">
        <div class="service-icon">
            <i class="fas fa-wallet"></i>
        </div>
        <div class="service-text">
            <h2>Gestão Ágil de Ativos</h2>
            <p>
                Centralize o controle do seu patrimônio com agilidade. Registre entradas e saídas
                de forma dinâmica, permitindo uma visão clara do fluxo de caixa e garantindo que cada 
                centavo trabalhe a favor do seu futuro.
            </p>
            <span class="impact">✔ Domínio total sobre o seu fluxo financeiro.</span>
        </div>
    </div>

    <div class="service-detail">
        <div class="service-icon">
            <i class="fas fa-chart-pie"></i>
        </div>
        <div class="service-text">
            <h2>Inteligência Analítica</h2>
            <p>
                Transforme dados em decisões estratégicas. O CRONOS processa suas movimentações e entrega
                relatórios visuais precisos. Identifique padrões de consumo e ajuste seu comportamento para 
                acelerar seus resultados financeiros.
            </p>
            <span class="impact">✔ Análise precisa para um planejamento vitorioso.</span>
        </div>
    </div>

    <div class="service-detail">
        <div class="service-icon">
            <i class="fas fa-lock"></i>
        </div>
        <div class="service-text">
            <h2>Segurança de Alto Nível</h2>
            <p>
                Proteção robusta para os seus dados. O CRONOS utiliza protocolos de segurança de ponta, 
                garantindo a integridade e a privacidade total das suas informações. Sua tranquilidade é 
                nossa prioridade absoluta.
            </p>
            <span class="impact">✔ Tecnologia aplicada à sua segurança e confiança.</span>
        </div>
    </div>

</div>

<footer>
    <p>&copy; 2026 CRONOS — Controle inteligente, tempo otimizado.</p>
</footer>

</body>
</html>