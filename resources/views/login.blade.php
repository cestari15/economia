<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRONOS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            /* Paleta: Mantida a base técnica, focada no azul profundo de CRONOS */
            --bg-gradient: linear-gradient(135deg, #001529 0%, #2563eb 50%, #00d4ff 100%);
            --brand-blue: #001529;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --white: #ffffff;
            --error-red: #ef4444;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text-main);
        }

        .auth-container {
            width: 100%;
            max-width: 420px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            padding: 45px;
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeIn 0.6s ease-out;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-text {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--brand-blue);
            text-decoration: none;
            letter-spacing: -1px;
        }

        .logo-text span {
            color: #00d4ff;
        }

        .auth-title {
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 8px;
        }

        /* Formulário */
        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--brand-blue);
            opacity: 0.6;
            transition: 0.3s;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #f1f5f9;
            border-radius: 15px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--brand-blue);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(0, 21, 41, 0.1);
        }

        .form-control:focus + i {
            opacity: 1;
        }

        /* Opções Adicionais */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-muted);
        }

        .remember-me input {
            cursor: pointer;
            accent-color: var(--brand-blue);
            width: 16px;
            height: 16px;
        }

        .forgot-pass {
            color: var(--brand-blue);
            text-decoration: none;
            transition: 0.2s;
        }

        .forgot-pass:hover {
            text-decoration: underline;
        }

        /* Botão */
        .btn-login {
            width: 100%;
            background: var(--brand-blue);
            color: var(--white);
            padding: 16px;
            border: none;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 21, 41, 0.3);
        }

        .btn-login:hover {
            background: #002d59;
            transform: translateY(-2px);
            box-shadow: 0 15px 20px -5px rgba(0, 21, 41, 0.4);
        }

        .btn-login:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
        }

        .auth-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .auth-footer a {
            color: var(--brand-blue);
            text-decoration: none;
            font-weight: 700;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="/" class="logo-text">CRO<span>NOS</span></a>
                <div class="auth-title">O controle do seu tempo e capital</div>
            </div>

            <form id="form-login">
                @csrf
                <div class="form-group">
                    <label class="form-label">E-mail</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="seu@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Senha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" id="remember"> Lembre-se de mim
                    </label>
                    <a href="{{ route('recuperar-senha.form') }}" class="forgot-pass">Esqueceu a senha?</a>
                </div>

                <button type="submit" class="btn-login" id="btn-submit">Acessar Cronos</button>
            </form>

            <div class="auth-footer">
                Novo por aqui? <a href="{{ route('register') }}">Criar conta gratuita</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#form-login').on('submit', function(e) {
                e.preventDefault();

                const btn = $('#btn-submit');
                const originalText = btn.html();
                
                let dados = {
                    email: $('#email').val(),
                    password: $('#password').val()
                };

                btn.html('<i class="fas fa-circle-notch fa-spin"></i> Validando Ciclo...').prop('disabled', true);

                $.ajax({
                    url: '{{ url("api/login") }}',
                    type: 'POST',
                    data: JSON.stringify(dados),
                    contentType: 'application/json',
                    success: function(response) {
                        if(response.status) {
                            localStorage.setItem('token', response.token);
                            localStorage.setItem('user', JSON.stringify(response.user));

                            Swal.fire({
                                icon: 'success',
                                title: 'Conectado',
                                text: 'Seu fluxo financeiro está pronto.',
                                showConfirmButton: false,
                                timer: 1500,
                                confirmButtonColor: '#001529'
                            }).then(() => {
                                window.location.href = '{{ route("relatorios") }}';
                            });
                        } else {
                            btn.html(originalText).prop('disabled', false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Acesso Negado',
                                text: response.message || 'Credenciais inválidas.',
                                confirmButtonColor: '#001529'
                            });
                        }
                    },
                    error: function(err) {
                        btn.html(originalText).prop('disabled', false);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro de Conexão',
                            text: 'Não foi possível estabelecer contato com o servidor.',
                            confirmButtonColor: '#001529'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>