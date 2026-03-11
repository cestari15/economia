<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRONOS - Calendário Inteligente</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        :root {
            --sidebar-bg: #000c17;
            --azul-vibrante: #2563eb;
            --azul-brilhante: #00d4ff;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --roxo-destaque: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
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

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            z-index: 40;
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

        .menu-item {
            padding: 16px 28px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #64748b;
            text-decoration: none;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }

        .menu-item:hover,
        .menu-item.active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.1) 0%, transparent 100%);
            color: white;
            border-left-color: var(--azul-brilhante);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .topbar {
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 40px;
            border-bottom: 1px solid var(--glass-border);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--glass-bg);
            padding: 8px 18px;
            border-radius: 50px;
            border: 1px solid var(--glass-border);
        }

        /* Calendar Card */
        .dashboard-container {
            padding: 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .calendar-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 25px;
            width: 100%;
            max-width: 1100px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .calendar-header h2 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 800;
        }

        .btn-nav {
            background: var(--glass-bg);
            color: white;
            border: 1px solid var(--glass-border);
            padding: 10px 15px;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-nav:hover {
            background: var(--azul-vibrante);
        }

        /* Grid do Calendário */
        .calendar-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
        }

        .calendar-table th {
            color: var(--azul-brilhante);
            text-transform: uppercase;
            font-size: 0.7rem;
            padding-bottom: 10px;
        }

        .calendar-table td {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            height: 90px;
            width: 14.28%;
            vertical-align: top;
            padding: 10px;
            transition: 0.2s;
            cursor: pointer;
        }

        .calendar-table td:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: var(--azul-brilhante);
        }

        .day-number {
            font-weight: 800;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .event-tag {
            background: var(--roxo-destaque);
            font-size: 0.65rem;
            padding: 3px 6px;
            border-radius: 5px;
            margin-top: 5px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .other-month {
            opacity: 0.2;
            pointer-events: none;
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-header"><i class="fas fa-clock"></i> CRO<span>NOS</span></div>
        <nav class="sidebar-menu">
            <a href="/relatorios" class="menu-item"><i class="fas fa-chart-pie"></i> Relatórios</a>
            <a href="/calendario" class="menu-item active"><i class="fas fa-calendar-alt"></i> Calendário</a>
            <a href="/anotacoes" class="menu-item"><i class="fas fa-edit"></i> Anotações</a>
            <a href="/clientes" class="menu-item" id="menu-admin" style="display: none;">
                <i class="fas fa-users-cog"></i> Clientes
            </a>
            <a href="/configuracoes" class="menu-item"><i class="fas fa-cog"></i> Configurações</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="user-info">
                <span id="user-display-name">Usúario</span>
                <i class="fas fa-user-circle fa-lg"></i>
            </div>
        </header>

        <section class="dashboard-container">
            <div class="calendar-card">
                <div class="calendar-header">
                    <button class="btn-nav" id="prev-month"><i class="fas fa-chevron-left"></i></button>
                    <h2 id="mes-ano">--</h2>
                    <button class="btn-nav" id="next-month"><i class="fas fa-chevron-right"></i></button>
                </div>

                <table class="calendar-table" id="tabela-calendario">
                    <thead>
                        <tr>
                            <th>Dom</th>
                            <th>Seg</th>
                            <th>Ter</th>
                            <th>Qua</th>
                            <th>Qui</th>
                            <th>Sex</th>
                            <th>Sáb</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        // --- 1. VALIDAÇÃO DE SESSÃO E SEGURANÇA ---
        const authData = JSON.parse(localStorage.getItem('auth_data'));
        const now = new Date().getTime();

        if (!authData || now > authData.expiry) {
            localStorage.removeItem('auth_data');
            window.location.href = '/login';
            return;
        }

        const token = authData.token;
        const user = authData.user;

        if (user && user.nome) {
            $('#user-display-name').text(user.nome);
            // Controle do menu admin
            if (user.tipo === 'admin') {
                $('#menu-admin').show();
            } else {
                $('#menu-admin').remove();
            }
        }

        // --- 2. CONFIGURAÇÃO DO CALENDÁRIO ---
        const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        let dataAtual = new Date();
        let mesVisivel = dataAtual.getMonth();
        let anoVisivel = dataAtual.getFullYear();
        let listaEventos = [];

        function carregarDados() {
            fetch('/api/calendario', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                listaEventos = (Array.isArray(data) ? data : []).map(ev => {
                    const [y, m, d] = ev.start.split('T')[0].split('-');
                    return {
                        id: ev.id,
                        title: ev.title,
                        date: new Date(y, m - 1, d)
                    };
                });
                renderizarCalendario();
            });
        }

        function renderizarCalendario() {
            const corpoTabela = $('#tabela-calendario tbody').empty();
            $('#mes-ano').text(`${meses[mesVisivel]} ${anoVisivel}`);

            const primeiroDiaSemana = new Date(anoVisivel, mesVisivel, 1).getDay();
            const totalDiasMes = new Date(anoVisivel, mesVisivel + 1, 0).getDate();

            let diaContador = 1;
            for (let i = 0; i < 6; i++) {
                let linha = $('<tr></tr>');
                let preencheuAlgo = false;

                for (let j = 0; j < 7; j++) {
                    if ((i === 0 && j < primeiroDiaSemana) || diaContador > totalDiasMes) {
                        linha.append('<td class="other-month"></td>');
                    } else {
                        preencheuAlgo = true;
                        const diaFixo = diaContador;
                        const celula = $(`<td><span class="day-number">${diaFixo}</span></td>`);

                        const eventosDoDia = listaEventos.filter(ev =>
                            ev.date.getFullYear() === anoVisivel &&
                            ev.date.getMonth() === mesVisivel &&
                            ev.date.getDate() === diaFixo
                        );

                        eventosDoDia.forEach(ev => {
                            celula.append(`<span class="event-tag">${ev.title}</span>`);
                        });

                        celula.on('click', () => abrirModal(diaFixo, eventosDoDia));
                        linha.append(celula);
                        diaContador++;
                    }
                }
                if (preencheuAlgo) corpoTabela.append(linha);
            }
        }

        // --- 3. MODAIS E AÇÕES ---
        window.excluirEvento = function(id) {
            const idLimpo = String(id).split('_')[0];
            fetch(`/api/calendario/${idLimpo}`, {
                method: 'DELETE',
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            })
            .then(() => { Swal.close(); carregarDados(); })
            .catch(() => Swal.fire('Erro', 'Não foi possível excluir.', 'error'));
        };

        function abrirModal(dia, eventosDoDia = []) {
            const dataFormatada = `${anoVisivel}-${String(mesVisivel + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
            
            let html = `<div style="text-align: left; font-family: sans-serif;">`;
            if (eventosDoDia.length > 0) {
                html += `<div style="margin-bottom: 20px;"><strong style="color: #a0aec0;">Eventos:</strong><ul style="list-style: none; padding: 0;">`;
                eventosDoDia.forEach(ev => {
                    html += `<li style="margin-bottom: 8px; padding: 10px; background: #0b233a; border-radius: 8px; display: flex; justify-content: space-between;">
                        <span>${ev.title}</span>
                        <button onclick="excluirEvento('${ev.id}')" style="background: #e53e3e; border:none; color:white; cursor:pointer; padding: 4px 10px; border-radius: 6px;">Remover</button>
                    </li>`;
                });
                html += `</ul></div>`;
            }

            html += `<div style="border-top: 1px solid #1e3a5a; padding-top: 15px;">
                <label>Título:</label><input id="swal-input-title" class="swal2-input">
                <label>Dia do Lembrete:</label><input id="swal-input-lembrete" type="number" class="swal2-input">
                <input type="checkbox" id="swal-input-recorrente"> <label>Repetir todo mês</label>
            </div>`;

            Swal.fire({
                title: `Agendar para dia ${dia}`,
                html: html,
                background: '#0a1929', color: '#fff', confirmButtonColor: '#5a67d8',
                preConfirm: () => {
                    return {
                        title: document.getElementById('swal-input-title').value,
                        data_evento: dataFormatada,
                        dia_lembrete: document.getElementById('swal-input-lembrete').value,
                        recorrente: document.getElementById('swal-input-recorrente').checked ? 1 : 0
                    };
                }
            }).then(res => { if (res.isConfirmed && res.value.title) salvarEvento(res.value); });
        }

        function salvarEvento(payload) {
            fetch('/api/calendario', {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            }).then(() => carregarDados());
        }

        // Navegação
        $('#prev-month').click(() => { mesVisivel--; if (mesVisivel < 0) { mesVisivel = 11; anoVisivel--; } renderizarCalendario(); });
        $('#next-month').click(() => { mesVisivel++; if (mesVisivel > 11) { mesVisivel = 0; anoVisivel++; } renderizarCalendario(); });

        carregarDados();
    });
</script>
    <script src="{{ asset('js/theme.js') }}"></script>
</body>

</html>
