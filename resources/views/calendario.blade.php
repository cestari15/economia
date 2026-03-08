<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário - CRONOS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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

        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            height: 100vh;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--glass-border);
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.5);
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

        .sidebar-header span { color: var(--azul-brilhante); }

        .sidebar-menu { flex: 1; padding: 25px 0; }

        .menu-item {
            padding: 16px 28px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #64748b;
            text-decoration: none;
            transition: all 0.4s ease;
            font-size: 0.95rem;
            border-left: 4px solid transparent;
        }

        .menu-item:hover, .menu-item.active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.1) 0%, transparent 100%);
            color: white;
            border-left: 4px solid var(--azul-brilhante);
        }

        .main-content { flex: 1; display: flex; flex-direction: column; overflow: hidden; position: relative; }

        .topbar {
            height: 90px;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 40px;
            border-bottom: 1px solid var(--glass-border);
            z-index: 30;
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

        #user-display-name {
            font-size: 1rem;
            font-weight: 700;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .user-info i { font-size: 1.6rem; color: var(--azul-brilhante); }

        .dashboard-container {
            padding: 40px;
            margin-top: 90px;
            max-width: 1300px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .calendar-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }

        .calendar-header h2 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 800;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-nav {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border: 1px solid var(--glass-border);
            padding: 8px 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-nav:hover { background: var(--azul-vibrante); border-color: var(--azul-brilhante); }

        .calendar-table { width: 100%; border-collapse: separate; border-spacing: 6px; }

        .calendar-table th { text-transform: uppercase; font-size: 0.75rem; color: var(--azul-brilhante); padding: 10px; }

        .calendar-table td {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            height: 75px;
            vertical-align: top;
            padding: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .calendar-table td:hover { background: rgba(255, 255, 255, 0.08); border-color: var(--azul-brilhante); }

        .day-number { font-weight: 800; font-size: 0.9rem; display: block; margin-bottom: 4px; }

        .event-tag {
            background: var(--roxo-destaque);
            font-size: 0.6rem;
            padding: 2px 6px;
            border-radius: 4px;
            margin-top: 4px;
            display: block;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header"><i class="fas fa-clock"></i> CRO<span>NOS</span></div>
        <div class="sidebar-menu">
            <a href="/relatorios" class="menu-item"><i class="fas fa-chart-pie"></i> Relatórios</a>
            <a href="/calendario" class="menu-item active"><i class="fas fa-calendar-alt"></i> Calendário</a>
            <a href="/anotacoes" class="menu-item"><i class="fas fa-edit"></i> Anotações</a>
            <a href="/profile" class="menu-item"><i class="fas fa-user"></i> Perfil</a>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="user-info">
                <span id="user-display-name">Usuário</span>
                <i class="fas fa-user-circle fa-lg"></i>
            </div>
        </div>

        <div class="dashboard-container">
            <div class="calendar-card">
                <div class="calendar-header">
                    <button class="btn-nav" id="prev-month"><i class="fas fa-chevron-left"></i></button>
                    <h2 id="mes-ano">Mês / Ano</h2>
                    <button class="btn-nav" id="next-month"><i class="fas fa-chevron-right"></i></button>
                </div>

                <table class="calendar-table" id="tabela-calendario">
                    <thead>
                        <tr>
                            <th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      $(document).ready(function() {
    const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    let dataHoje = new Date();
    let mes = dataHoje.getMonth();
    let ano = dataHoje.getFullYear();
    let eventos = [];
    
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user'));

    if (!token) { window.location.href = '/login'; return; }
    if (user) $('#user-display-name').text(user.nome);

    function carregarEventos() {
        fetch('/api/calendario', { 
            headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' } 
        })
        .then(res => res.ok ? res.json() : Promise.reject())
        .then(data => {
            // Normaliza as datas dos eventos para evitar problemas de fuso horário
            eventos = data.map(ev => ({
                title: ev.title,
                date: new Date(ev.start)
            }));
            gerarCalendario(ano, mes);
        })
        .catch(() => Swal.fire('Erro', 'Não foi possível carregar os eventos.', 'error'));
    }

    function gerarCalendario(anoParam, mesParam) {
        const tabelaBody = $('#tabela-calendario tbody');
        tabelaBody.empty();
        
        const primeiroDia = new Date(anoParam, mesParam, 1).getDay();
        const totalDias = new Date(anoParam, mesParam + 1, 0).getDate();
        
        $('#mes-ano').text(`${meses[mesParam]} ${anoParam}`);
        
        let dia = 1;
        for (let i = 0; i < 6; i++) {
            let tr = $('<tr></tr>');
            for (let j = 0; j < 7; j++) {
                if ((i === 0 && j < primeiroDia) || dia > totalDias) {
                    tr.append('<td></td>');
                } else {
                    let td = $(`<td><span class="day-number">${dia}</span></td>`);
                    
                    // Compara data sem considerar horas (usando UTC ou Local consistente)
                    let eventosDoDia = eventos.filter(ev => 
                        ev.date.getFullYear() === anoParam && 
                        ev.date.getMonth() === mesParam && 
                        ev.date.getDate() === dia
                    );

                    eventosDoDia.forEach(ev => {
                        td.append(`<span class="event-tag">${ev.title}</span>`);
                    });

                    let dataCelula = new Date(anoParam, mesParam, dia);
                    td.click(() => abrirModalEvento(dataCelula));
                    tr.append(td);
                    dia++;
                }
            }
            if (dia > totalDias && i === 0) { /* evita renderizar linhas vazias desnecessárias */ }
            tabelaBody.append(tr);
            if (dia > totalDias) break;
        }
    }

    function abrirModalEvento(dataSel) {
        // Formata data como YYYY-MM-DD
        const dtStr = dataSel.toLocaleDateString('en-CA'); 
        
        Swal.fire({
            title: 'Novo Evento',
            background: '#001529',
            color: '#fff',
            html: `<input id="n-ev" class="swal2-input" placeholder="Nome do Evento" autofocus>`,
            confirmButtonText: 'Salvar',
            confirmButtonColor: '#2563eb',
            preConfirm: () => {
                const title = Swal.getPopup().querySelector('#n-ev').value;
                if (!title) Swal.showValidationMessage('Por favor, insira o nome do evento');
                return { title: title, start: dtStr };
            }
        }).then(result => {
            if (result.isConfirmed) {
                fetch('/api/calendario', {
                    method: 'POST',
                    headers: { 
                        'Authorization': 'Bearer ' + token, 
                        'Content-Type': 'application/json',
                        'Accept': 'application/json' 
                    },
                    body: JSON.stringify(result.value)
                })
                .then(res => res.ok ? carregarEventos() : Swal.fire('Erro', 'Falha ao salvar evento.', 'error'))
                .catch(() => Swal.fire('Erro', 'Falha de conexão.', 'error'));
            }
        });
    }

    $('#prev-month').click(() => { mes--; if (mes < 0) { mes = 11; ano--; } gerarCalendario(ano, mes); });
    $('#next-month').click(() => { mes++; if (mes > 11) { mes = 0; ano++; } gerarCalendario(ano, mes); });
    
    carregarEventos();
});
    </script>
</body>
</html>