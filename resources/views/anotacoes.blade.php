<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anotações - CRONOS</title>

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

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

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

        .dashboard-container {
            padding: 40px;
            margin-top: 90px;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 35px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .form-card h2 {
            margin-bottom: 30px;
            font-size: 1.6rem;
            text-align: center;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.75rem;
            color: var(--azul-brilhante);
            font-weight: 700;
            text-transform: uppercase;
        }

        .form-control {
            width: 100%;
            padding: 14px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: white;
            box-sizing: border-box;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--azul-vibrante);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 800;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-3px);
        }


        /* Garante que o select tenha o mesmo estilo dos inputs */
        select.form-control {
            appearance: none;
            /* Remove o estilo padrão do SO */
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2300d4ff%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 15px top 50%;
            background-size: 12px auto;
            cursor: pointer;
        }

        /* Cor das opções no dropdown (necessário em alguns navegadores) */
        select.form-control option {
            background-color: #001529;
            color: white;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header"><i class="fas fa-clock"></i> CRO<span>NOS</span></div>
        <div class="sidebar-menu">
            <a href="/relatorios" class="menu-item"><i class="fas fa-chart-pie"></i> Relatórios</a>
            <a href="/calendario" class="menu-item"><i class="fas fa-calendar-alt"></i> Calendário</a>
            <a href="/anotacoes" class="menu-item active"><i class="fas fa-edit"></i> Anotações</a>
            <a href="/configuracoes" class="menu-item"><i class="fas fa-user"></i> Configurações</a>
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
            <div class="form-card">
                <h2><i class="fas fa-pen-to-square"></i> Cadastrar Anotação</h2>
                <form id="form-anotacao">
                    <div class="form-group">
                        <label>Nome da Anotação</label>
                        <input type="text" id="nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Categoria</label>
                        <select id="categoria" class="form-control" required>
                            <option value="" disabled selected>Selecione uma categoria</option>
                            <option value="Alimentação">Alimentação</option>
                            <option value="Transporte">Transporte</option>
                            <option value="Moradia">Moradia</option>
                            <option value="Educação">Educação</option>
                            <option value="Lazer">Lazer</option>
                            <option value="Saúde">Saúde</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valor (R$)</label>
                        <input type="number" step="0.01" id="valor" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" id="data" class="form-control" required>
                    </div>
                    <button type="submit" class="btn-submit">SALVAR ANOTAÇÃO</button>
                </form>
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

            if (user) $('#user-display-name').text(user.nome);

            $('#form-anotacao').on('submit', function(e) {
                e.preventDefault();

                // Referência ao botão para feedback visual
                const btnSubmit = $(this).find('.btn-submit');
                const originalText = btnSubmit.text();

                btnSubmit.prop('disabled', true).text('A GUARDAR...');

                const dados = {
                    nome: $('#nome').val(),
                    categoria: $('#categoria').val(),
                    valor: $('#valor').val(),
                    data: $('#data').val()
                };

                $.ajax({
                    url: '{{ url('api/anotacoes/store') }}',
                    type: 'POST',
                    data: JSON.stringify(dados),
                    contentType: 'application/json',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        // TRATAMENTO DE ERRO DENTRO DO SUCCESS (Caso o status seja 200 mas com erro no JSON)
                        if (response.success === false || response.error) {
                            exibirErro(response);
                            return;
                        }

                        // SUCESSO REAL
                        Swal.fire({
                            title: 'Sucesso!',
                            text: response.message || 'Anotação gravada com sucesso!',
                            icon: 'success',
                            background: '#001529',
                            color: '#fff',
                            confirmButtonColor: '#2563eb'
                        });

                        $('#form-anotacao')[0].reset();
                    },
                    error: function(xhr) {
                        // TRATAMENTO DE ERRO VIA STATUS HTTP (422, 500, etc)
                        exibirErro(xhr.responseJSON);
                    },
                    complete: function() {
                        // Reativa o botão
                        btnSubmit.prop('disabled', false).text(originalText);
                    }
                });
            });

            // Função centralizada para processar e exibir mensagens de erro
            function exibirErro(dados) {
                let mensagem = 'Ocorreu um erro inesperado.';

                if (dados && dados.error) {
                    // Se o erro vier como um objeto de campos (ex: nome: ["erro"])
                    const primeiroCampo = Object.keys(dados.error)[0];
                    mensagem = dados.error[primeiroCampo][0];
                } else if (dados && dados.message) {
                    // Se vier uma mensagem direta
                    mensagem = dados.message;
                }

                Swal.fire({
                    title: 'Erro de Validação',
                    text: mensagem,
                    icon: 'error',
                    background: '#001529',
                    color: '#fff',
                    confirmButtonColor: '#2563eb'
                });
            }
        });
    </script>
    <script src="{{ asset('js/theme.js') }}"></script>
</body>

</html>
