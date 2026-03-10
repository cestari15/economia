<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CRONOS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        :root {
            --sidebar-bg: #000c17;
            --sidebar-hover: rgba(255, 255, 255, 0.1);
            --azul-vibrante: #2563eb;
            --azul-brilhante: #00d4ff;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-secondary: #94a3b8;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top left, #001529 0%, #000c17 100%);
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            color: white;
            overflow: hidden;
        }

        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            height: 100vh;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--glass-border);
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.5);
        }

        .sidebar-header {
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.3rem;
            letter-spacing: 3px;
            border-bottom: 1px solid var(--glass-border);
        }

        .sidebar-header span {
            color: var(--azul-brilhante);
        }

        .sidebar-menu {
            flex: 1;
            padding: 25px 0;
        }

        .menu-item {
            padding: 16px 28px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #64748b;
            text-decoration: none;
            transition: 0.4s ease;
            border-left: 4px solid transparent;
        }

        .menu-item:hover,
        .menu-item.active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.1), transparent);
            color: white;
            border-left: 4px solid var(--azul-brilhante);
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            position: relative;
        }

        .topbar {
            height: 90px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 40px;
            border-bottom: 1px solid var(--glass-border);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.03);
            padding: 8px 18px;
            border-radius: 50px;
            border: 1px solid var(--glass-border);
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 6px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 800;
        }

        .dashboard-container {
            padding: 40px;
            max-width: 1200px;
            margin: auto;
        }

        .report-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .total-value {
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .grid-charts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
        }

        h5 {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        select {
            margin: 15px 0;
            padding: 8px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        /* Estilo base para os selects */
        select {
            margin: 15px 0;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid var(--glass-border);
            background: rgba(255, 255, 255, 0.1);
            /* Um pouco mais visível */
            color: white;
            cursor: pointer;
            outline: none;
            transition: all 0.3s ease;
        }

        select:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--azul-brilhante);
        }

        /* IMPORTANTE: Estiliza as opções dentro do dropdown */
        select option {
            background-color: #001529;
            /* Fundo sólido para garantir contraste */
            color: white;
            padding: 10px;
        }

        /* Remove estilos inline que podem conflitar */
        #mes-select,
        #select-mes {
            width: 100%;
            /* Opcional: faz ocupar a largura do card */
            max-width: 200px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header"><i class="fas fa-clock"></i> CRO<span>NOS</span></div>
        <div class="sidebar-menu">
            <a href="/relatorios" class="menu-item active"><i class="fas fa-chart-pie"></i> Relatórios</a>
            <a href="/calendario" class="menu-item"><i class="fas fa-calendar-alt"></i> Calendário</a>
            <a href="/anotacoes" class="menu-item "><i class="fas fa-edit"></i> Anotações</a>
            <a href="/configuracoes" class="menu-item"><i class="fas fa-user"></i> Configurações</a>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span id="user-display-name">Usuário</span>
                <button class="btn-logout" id="btn-logout">LOGOUT</button>
            </div>
        </div>

        <div class="dashboard-container">

            <div class="report-card">
                <h5><i class="fas fa-wallet"></i> Saldo Total Acumulado</h5>
                <div class="total-value" id="total-geral">R$ 0,00</div>
            </div>

            <div class="grid-charts">

                <div class="report-card">
                    <h5><i class="fas fa-chart-pie"></i> Gastos por Categoria</h5>
                    <div id="chart-categoria"></div>
                </div>

                <div class="report-card">
                    <h5>
                        <i class="fas fa-chart-bar"></i> Resumo Mensal
                    </h5>

                    <select id="mes-select">
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>

                    <div id="chart-mes"></div>
                </div>

                <div class="report-card">
                    <h5><i class="fas fa-layer-group"></i> Categoria Mensal</h5>
                    <select id="select-mes">
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                    <div id="chart-categoria-mensal"></div>
                </div>

                <div class="report-card">
                    <h5><i class="fas fa-calendar"></i> Resumo Anual</h5>
                    <div id="chart-anual"></div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const token = localStorage.getItem('token');
            const userData = JSON.parse(localStorage.getItem('user') || '{}');

            if (!token) {
                window.location.href = '/login';
                return;
            }
            if (userData.nome) document.getElementById('user-display-name').innerText = userData.nome;

            async function safeFetch(url) {
                try {
                    const res = await fetch(url, {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    });
                    return await res.json();
                } catch (e) {
                    return {
                        status: false
                    };
                }
            }

            const chartConfig = {
                theme: {
                    mode: 'dark'
                },
                chart: {
                    background: 'transparent',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#2563eb', '#10b981', '#f59e0b', '#ef4444']
            };
            const now = new Date();
            const ano = now.getFullYear();

            async function atualizarSaldoTotal() {
                const data = await safeFetch('/api/relatorios/total-geral');
                const displayElement = document.getElementById('total-geral');

                if (data && data.total_geral !== undefined) {
                    // Converte para número, trata NaN e formata como moeda BRL
                    const valor = parseFloat(data.total_geral);
                    displayElement.innerText = (!isNaN(valor) ? valor : 0).toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                } else {
                    displayElement.innerText = "R$ 0,00";
                }
            }
            atualizarSaldoTotal();

            // 1. GERAL (Donut)
            const dataCat = await safeFetch('/api/relatorios/por-categoria');
            if (dataCat.status) {
                new ApexCharts(document.querySelector("#chart-categoria"), {
                    ...chartConfig,
                    chart: {
                        type: 'donut',
                        height: 300
                    },
                    series: dataCat.totais_por_categoria.map(c => Number(c.total)),
                    labels: dataCat.totais_por_categoria.map(c => c.categoria)
                }).render();
            }

            // 2. RESUMO MENSAL (Bar) - Agora Dinâmico
            let chartMes = new ApexCharts(document.querySelector("#chart-mes"), {
                ...chartConfig,
                chart: {
                    type: 'bar',
                    height: 300
                },
                series: [{
                    name: 'Total',
                    data: []
                }],
                xaxis: {
                    categories: []
                }
            });
            chartMes.render();

            async function updateResumoMes(mes) {
                const data = await safeFetch(`/api/relatorios/por-mes/${ano}/${mes}`);
                if (data.status) {
                    chartMes.updateOptions({
                        xaxis: {
                            categories: [`${mes}/${ano}`]
                        }
                    });
                    chartMes.updateSeries([{
                        name: 'Total',
                        data: [Number(data.total)]
                    }]);
                }
            }

            const selectResumo = document.getElementById('mes-select');
            selectResumo.addEventListener('change', (e) => updateResumoMes(e.target.value));
            updateResumoMes(selectResumo.value); // Carrega inicial

            // 3. CATEGORIA MENSAL (Donut)
            let chartCatMensal = new ApexCharts(document.querySelector("#chart-categoria-mensal"), {
                ...chartConfig,
                chart: {
                    type: 'donut',
                    height: 300
                },
                series: [],
                labels: []
            });
            chartCatMensal.render();

            async function updateCatMensal(mes) {
                const data = await safeFetch(`/api/relatorios/categoria-por-mes/${ano}/${mes}`);
                if (data.status) {
                    chartCatMensal.updateOptions({
                        labels: data.totais.map(i => i.categoria)
                    });
                    chartCatMensal.updateSeries(data.totais.map(i => Number(i.total)));
                }
            }

            const selectCat = document.getElementById('select-mes');
            selectCat.addEventListener('change', (e) => updateCatMensal(e.target.value));
            updateCatMensal(selectCat.value); // Carrega inicial

            // 4. ANUAL (Line)
            const dataAnual = await safeFetch(`/api/relatorios/anual/${ano}`);
            if (dataAnual.status) {
                new ApexCharts(document.querySelector("#chart-anual"), {
                    ...chartConfig,
                    chart: {
                        type: 'line',
                        height: 300
                    },
                    series: [{
                        name: 'Gastos',
                        data: dataAnual.meses.map(m => Number(m.total))
                    }],
                    xaxis: {
                        categories: dataAnual.meses.map(m => m.mes)
                    }
                }).render();
            }

            // Logout
            document.getElementById('btn-logout').addEventListener('click', () => {
                localStorage.clear();
                window.location.href = '/login';
            });
        });
    </script>
    <script src="{{ asset('js/theme.js') }}"></script>
</body>

</html>
