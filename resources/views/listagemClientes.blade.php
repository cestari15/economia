<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Clientes - CRONOS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
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

        /* Dashboard Container */
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
            padding: 30px;
            width: 100%;
            max-width: 1100px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .calendar-header {
            margin-bottom: 25px;
            border-bottom: 1px solid var(--glass-border);
            padding-bottom: 20px;
        }

        .calendar-header h2 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 800;
        }

        /* Tabela */
        .table-responsive {
            overflow-x: auto;
        }

        .calendar-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .calendar-table th {
            color: var(--azul-brilhante);
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--glass-border);
        }

        .calendar-table td {
            padding: 20px 15px;
            border-bottom: 1px solid var(--glass-border);
            color: #e2e8f0;
        }

        .calendar-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .btn-nav {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border: 1px solid var(--glass-border);
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-nav:hover {
            background: #e53e3e;
            border-color: #e53e3e;
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header"><i class="fas fa-clock"></i> CRO<span>NOS</span></div>
        <nav class="sidebar-menu">
            <a href="/relatorios" class="menu-item"><i class="fas fa-chart-pie"></i> Relatórios</a>
            <a href="/calendario" class="menu-item"><i class="fas fa-calendar-alt"></i> Calendário</a>
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
                <span id="user-display-name">Usuário</span>
                <i class="fas fa-user-circle fa-lg"></i>
            </div>
        </header>

        <section class="dashboard-container">
            <div class="calendar-card">
                <div class="calendar-header">
                    <h2><i class="fas fa-users" style="color: var(--azul-brilhante);"></i> Clientes Cadastrados</h2>
                </div>
                <div class="table-responsive">
                    <table class="calendar-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Data de Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="lista-clientes-body"></tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        // --- 1. VALIDAÇÃO DE SESSÃO COM EXPIRAÇÃO ---
        const authData = JSON.parse(localStorage.getItem('auth_data'));
        const now = new Date().getTime();

        // Verifica se existe sessão E se o usuário é admin
        if (!authData || now > authData.expiry || authData.user.tipo !== 'admin') {
            window.location.href = '/calendario'; // Redireciona usuários não autorizados
            return;
        }

        const token = authData.token;
        const user = authData.user;

        // --- 2. CONFIGURAÇÃO DA INTERFACE ---
        if (user && user.nome) {
            $('#user-display-name').text(user.nome);
        }

        // Garante que o menu admin esteja visível, já que só admins chegam aqui
        $('#menu-admin').show();

        // --- 3. GESTÃO DE CLIENTES ---
        function carregarClientes() {
            fetch('/api/clientes/listar', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(response => {
                if (response.status && response.data) {
                    const tbody = $('#lista-clientes-body').empty();
                    response.data.forEach(c => {
                        tbody.append(`
                            <tr>
                                <td>#${c.id}</td>
                                <td>${c.nome}</td>
                                <td>${c.email}</td>
                                <td>${new Date(c.created_at).toLocaleDateString()}</td>
                                <td>
                                    <button class="btn-nav" onclick="excluirCliente(${c.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }
            })
            .catch(err => console.error("Erro ao carregar clientes:", err));
        }

        window.excluirCliente = function(id) {
            Swal.fire({
                title: 'Confirmar exclusão?',
                text: "Esta ação não pode ser desfeita.",
                icon: 'warning',
                background: '#0a1929',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b'
            }).then(res => {
                if (res.isConfirmed) {
                    fetch(`/api/clientes/${id}`, {
                        method: 'DELETE',
                        headers: { 'Authorization': `Bearer ${token}` }
                    }).then(() => carregarClientes());
                }
            });
        };

        // Início da execução
        carregarClientes();
    });
</script>
</body>

</html>
