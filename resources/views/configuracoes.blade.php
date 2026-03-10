<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - CRONOS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
            --danger: #ef4444;
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

        /* Sidebar Reutilizada */
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
            transition: all 0.4s ease;
            font-size: 0.95rem;
            border-left: 4px solid transparent;
        }

        .menu-item:hover,
        .menu-item.active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.1) 0%, transparent 100%);
            color: white;
            border-left: 4px solid var(--azul-brilhante);
        }

        /* Conteúdo Principal */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            position: relative;
        }

        .topbar {
            height: 90px;
            min-height: 90px;
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

        .settings-container {
            padding: 40px;
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .settings-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 25px;
            transition: transform 0.3s;
        }

        .settings-card h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--azul-brilhante);
        }

        /* Formulários e Inputs */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            padding: 12px;
            color: white;
            box-sizing: border-box;
            outline: none;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--azul-brilhante);
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-save {
            background: var(--azul-vibrante);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .btn-save:hover {
            filter: brightness(1.2);
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.4);
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .btn-danger:hover {
            background: var(--danger);
            color: white;
        }

        /* Switches e Opções */
        .option-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--glass-border);
        }

        .option-row:last-child {
            border-bottom: none;
        }

        .account-info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .account-info-item span:first-child {
            color: #94a3b8;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header"><i class="fas fa-clock"></i> CRO<span>NOS</span></div>
        <div class="sidebar-menu">
            <a href="/relatorios" class="menu-item"><i class="fas fa-chart-pie"></i> Relatórios</a>
            <a href="/calendario" class="menu-item"><i class="fas fa-calendar-alt"></i> Calendário</a>
            <a href="/anotacoes" class="menu-item"><i class="fas fa-edit"></i> Anotações</a>
            <a href="/configuracoes" class="menu-item active"><i class="fas fa-user"></i> Configurações</a>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="user-info">
                <span id="user-display-name">Carregando...</span>
                <i class="fas fa-user-circle fa-lg"></i>
            </div>
        </div>

        <div class="settings-container">
            <h1 style="margin-bottom: 30px; font-weight: 800;">Configurações</h1>

            <div class="settings-grid">

                <div class="settings-card">
                    <h3><i class="fas fa-user"></i> Perfil</h3>
                    <form id="form-perfil">
                        <div class="form-group">
                            <label>Nome Completo</label>
                            <input type="text" class="form-control" id="perfil-nome" placeholder="Seu nome">
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" class="form-control" id="perfil-email" placeholder="seu@email.com">
                        </div>
                        <button type="submit" class="btn-save">Salvar Alterações</button>
                    </form>
                </div>

                <div class="settings-card">
                    <h3><i class="fas fa-shield-alt"></i> Segurança</h3>
                    <form id="form-senha">
                        <div class="form-group">
                            <label>Senha Atual</label>
                            <input type="password" class="form-control" id="senha-atual">
                        </div>
                        <div class="form-group">
                            <label>Nova Senha</label>
                            <input type="password" class="form-control" id="nova-senha">
                        </div>
                        <div class="form-group">
                            <label>Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="confirma-senha">
                        </div>
                        <button type="submit" class="btn-save">Alterar Senha</button>
                    </form>
                </div>

                <div class="settings-card">
                    <h3><i class="fas fa-palette"></i> Preferências</h3>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Moeda Padrão</label>
                        <select class="form-control" id="pref-moeda">
                            <option value="BRL">BRL (R$)</option>
                            <option value="USD">USD ($)</option>
                            <option value="EUR">EUR (€)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Início do Mês Financeiro</label>
                        <input type="number" class="form-control" id="financeiro-inicio" min="1" max="31"
                            value="1">
                    </div>
                </div>

                <div class="settings-card">
                    <h3><i class="fas fa-bell"></i> Notificações</h3>
                    <div class="option-row">
                        <span>Lembretes de Calendário</span>
                        <input type="checkbox" checked>
                    </div>
                    <div class="option-row">
                        <span>Alertas de Contas</span>
                        <input type="checkbox" checked>
                    </div>
                    <div class="option-row">
                        <span>Resumo Financeiro Semanal</span>
                        <input type="checkbox">
                    </div>
                </div>

                <div class="settings-card">
                    <h3><i class="fas fa-info-circle"></i> Dados da Conta</h3>
                    <div class="account-info-item">
                        <span>Membro desde</span>
                        <span id="conta-criada">Carregando...</span>
                    </div>
                    <div class="account-info-item">
                        <span>Último Login</span>
                        <span id="conta-login">Carregando...</span>
                    </div>
                    <div class="account-info-item">
                        <span>Plano Atual</span>
                        <span id="plano-atual"
                            style="color: var(--azul-brilhante); font-weight: 700;">Carregando...</span>
                    </div>
                </div>

                <div class="settings-card" style="border-color: rgba(239, 68, 68, 0.3);">
                    <h3 style="color: var(--danger);"><i class="fas fa-exclamation-triangle"></i> Zona de Perigo</h3>
                    <p style="font-size: 0.8rem; color: #94a3b8;">Ao excluir sua conta, todos os dados de calendário,
                        financeiro e anotações serão apagados permanentemente.</p>
                    <button class="btn-save btn-danger" id="btn-deletar-conta">Excluir Minha Conta</button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');
            const user = JSON.parse(localStorage.getItem('user'));

            if (!token) {
                window.location.href = '/login';
                return;
            }

            // Preencher dados iniciais
            if (user) {
                $('#user-display-name').text(user.nome);
                $('#perfil-nome').val(user.nome);
                $('#perfil-email').val(user.email);
            }

            // 1. Atualizar Perfil
            $('#form-perfil').submit(function(e) {
                e.preventDefault();
                const data = {
                    nome: $('#perfil-nome').val(),
                    email: $('#perfil-email').val(),
                    foto: $('#perfil-foto').val()
                };

                fetch('/api/cliente', {
                        method: 'PUT',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(res => res.ok ? Swal.fire('Sucesso', 'Perfil atualizado!', 'success') : Promise
                        .reject())
                    .catch(() => Swal.fire('Erro', 'Falha ao atualizar perfil.', 'error'));
            });

            // 2. Alterar Senha
            $('#form-senha').submit(function(e) {
                e.preventDefault();
                if ($('#nova-senha').val() !== $('#confirma-senha').val()) {
                    return Swal.fire('Erro', 'As senhas não coincidem.', 'error');
                }

                fetch('/api/cliente/senha', {
                        method: 'PUT',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            senha_atual: $('#senha-atual').val(),
                            nova_senha: $('#nova-senha').val()
                        })
                    })
                    .then(res => res.ok ? Swal.fire('Sucesso', 'Senha alterada!', 'success') : Promise
                        .reject())
                    .catch(() => Swal.fire('Erro', 'Senha atual incorreta.', 'error'));
            });

            // 3. Excluir Conta
            $('#btn-deletar-conta').click(function() {
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Esta ação é irreversível e apagará todos os seus dados!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sim, excluir tudo!',
                    background: '#001529',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('/api/cliente', {
                                method: 'DELETE',
                                headers: {
                                    'Authorization': 'Bearer ' + token
                                }
                            })
                            .then(res => {
                                if (res.ok) {
                                    localStorage.clear();
                                    window.location.href = '/login';
                                }
                            });
                    }
                });
            });

            // Buscar dados reais da conta
            fetch('/api/cliente/dados', {
                    headers: {
                        'Authorization': 'Bearer ' + token // Usando o token que você já tem
                    }
                })
                .then(res => res.json())
                .then(data => {
                    $('#conta-criada').text(data.criado_em);
                    $('#conta-login').text(data.ultimo_login);
                    // Se quiser mudar a cor do plano dinamicamente:
                    const spanPlano = $('#plano-atual');
                    spanPlano.text(data.plano);
                    if (data.plano === 'PREMIUM') {
                        spanPlano.css('color', 'var(--azul-brilhante)');
                    }
                });
        });
    </script>
    <script src="{{ asset('js/theme.js') }}"></script>
</body>

</html>
