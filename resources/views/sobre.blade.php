<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - CRONOS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --azul-deep: #001529;
            --azul-vibrante: #2563eb;
            --azul-botao: #00d4ff;
        }
        body { font-family: 'Inter', sans-serif; margin: 0; background: #ffffff; color: #1e293b; line-height: 1.6; }
        
        header { background: var(--azul-deep); padding: 1rem 10%; display: flex; justify-content: space-between; align-items: center; }
        .logo-text { color: white; font-size: 1.4rem; font-weight: bold; text-decoration: none; }
        .logo-text span { color: var(--azul-botao); }

        .about-hero {
            background: #f8fafc;
            padding: 100px 10%;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }
        .about-hero h1 { font-size: 3rem; color: var(--azul-deep); margin-bottom: 20px; }

        .content-section { padding: 80px 10%; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        
        .text-box h2 { color: var(--azul-vibrante); font-size: 2rem; margin-bottom: 20px; }
        .text-box p { font-size: 1.1rem; color: #475569; margin-bottom: 20px; }

        .mission-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 60px 10%;
            background: var(--azul-deep);
            color: white;
        }
        .m-card { text-align: center; padding: 20px; }
        .m-card i { font-size: 2.5rem; color: var(--azul-botao); margin-bottom: 15px; }
        
        .btn-back {
            color: white;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid var(--azul-botao);
            padding: 10px 20px;
            border-radius: 50px;
            transition: 0.3s;
        }
        .btn-back:hover { background: var(--azul-botao); color: var(--azul-deep); }
    </style>
</head>
<body>

    <header>
        <a href="/" class="logo-text">CRO<span>NOS</span></a>
        <a href="/" class="btn-back"><i class="fas fa-arrow-left"></i> Voltar</a>
    </header>

    <section class="about-hero">
        <h1>Nossa Missão</h1>
        <p style="max-width: 700px; margin: 0 auto; font-size: 1.2rem; color: #64748b;">
            Empoderar indivíduos a assumirem o controle total de seu capital, otimizando o tempo através de uma gestão financeira inteligente e estratégica.
        </p>
    </section>

    <section class="content-section">
        <div class="text-box">
            <h2>Por que a CRONOS existe?</h2>
            <p>O tempo é o ativo mais valioso que possuímos. Frequentemente, a complexidade de sistemas obsoletos e a falta de clareza sobre o próprio fluxo de caixa consomem a energia que deveria ser focada na expansão do seu patrimônio.</p>
            <p>A <strong>CRONOS</strong> surgiu como a solução definitiva. Desenvolvemos uma plataforma que transforma a gestão de ativos em um processo rápido, preciso e direto, para que você nunca mais perca o controle do que é seu.</p>
        </div>
        <div class="image-box">
            <img src="{{ asset('images/meta.svg') }}" alt="Gestão de Capital" style="width: 100%; max-width: 500px;">
        </div>
    </section>

    <section class="mission-cards">
        <div class="m-card">
            <i class="fas fa-microchip"></i>
            <h3>Precisão</h3>
            <p>Dados exatos para que cada decisão seja tomada com segurança total.</p>
        </div>
        <div class="m-card">
            <i class="fas fa-tachometer-alt"></i>
            <h3>Agilidade</h3>
            <p>Processos simplificados que economizam seu tempo e evitam retrabalho.</p>
        </div>
        <div class="m-card">
            <i class="fas fa-chart-line"></i>
            <h3>Alta Performance</h3>
            <p>Ferramentas desenhadas para medir, analisar e acelerar seus resultados.</p>
        </div>
    </section>

    <footer style="background: #f1f5f9; text-align: center; padding: 40px; color: #64748b;">
        <p>&copy; {{ date('Y') }} CRONOS — Domine seu tempo, controle seu capital.</p>
    </footer>

</body>
</html>