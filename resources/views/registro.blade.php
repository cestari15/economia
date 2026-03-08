<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - CRONOS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            /* Paleta: Azul Profundo (CRONOS) */
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
            max-width: 460px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
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
            font-size: 0.95rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 6px;
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

        .form-control.is-invalid {
            border-color: var(--error-red) !important;
        }

        .error-message {
            color: var(--error-red);
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 5px;
            display: none;
        }

        .btn-register {
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
            margin-top: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 21, 41, 0.3);
        }

        .btn-register:hover {
            background: #002d59;
            transform: translateY(-2px);
        }

        .auth-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--brand-blue);
            text-decoration: none;
            font-weight: 700;
        }

        .password-strength {
            width: 100%;
            height: 6px;
            background: #e2e8f0;
            border-radius: 10px;
            margin-top: 8px;
            overflow: hidden;
        }

        #strength-bar {
            height: 100%;
            width: 0%;
            transition: 0.3s;
        }

        #strength-text {
            font-size: 0.75rem;
            font-weight: 600;
            display: block;
            margin-top: 4px;
        }
    </style>
</head>

<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="/" class="logo-text">CRO<span>NOS</span></a>
                <div class="auth-title">Inicie o seu ciclo de gestão</div>
            </div>

            <form id="form-register" novalidate>
                @csrf
                <div class="form-group">
                    <label class="form-label">Nome Completo</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Seu nome">
                    </div>
                    <div id="error-nome" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">E-mail</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="seu@email.com">
                    </div>
                    <div id="error-email" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">CPF</label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card"></i>
                        <input type="text" id="cpf" name="cpf" class="form-control"
                            placeholder="000.000.000-00" maxlength="14">
                    </div>
                    <div id="error-cpf" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Senha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Crie uma senha forte">
                        <div class="password-strength">
                            <div id="strength-bar"></div>
                        </div>
                        <small id="strength-text"></small>
                    </div>
                    <div id="error-password" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirmar Senha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-shield-alt"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" placeholder="Repita sua senha">
                    </div>
                    <div id="error-password_confirmation" class="error-message"></div>
                </div>

                <button type="submit" class="btn-register" id="btn-submit">Criar Conta Cronos</button>
            </form>

            <div class="auth-footer">
                Já possui acesso? <a href="{{ route('login') }}">Fazer Login</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            function exibirErro(campo, mensagem) {
                const input = $(`#${campo}`);
                const erroDiv = $(`#error-${campo}`);
                input.addClass('is-invalid');
                erroDiv.text(mensagem).fadeIn();
            }

            // ==============================
            // CPF VALIDATION
            // ==============================
            function validarCPF(cpf) {
                cpf = cpf.replace(/[^\d]+/g, '');
                if (cpf.length !== 11) return false;
                if (/^(\d)\1+$/.test(cpf)) return false;

                let soma = 0,
                    resto;

                for (let i = 1; i <= 9; i++)
                    soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);

                resto = (soma * 10) % 11;
                if (resto >= 10) resto = 0;
                if (resto !== parseInt(cpf.substring(9, 10))) return false;

                soma = 0;
                for (let i = 1; i <= 10; i++)
                    soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);

                resto = (soma * 10) % 11;
                if (resto >= 10) resto = 0;
                if (resto !== parseInt(cpf.substring(10, 11))) return false;

                return true;
            }

            // ==============================
            // PASSWORD STRENGTH
            // ==============================
            function verificarForcaSenha(senha) {
                let forca = 0;

                if (senha.length >= 8) forca++;
                if (/[A-Z]/.test(senha)) forca++;
                if (/[a-z]/.test(senha)) forca++;
                if (/[0-9]/.test(senha)) forca++;
                if (/[^A-Za-z0-9]/.test(senha)) forca++;

                return forca;
            }

            $('#password').on('input', function() {
                let senha = $(this).val();
                let forca = verificarForcaSenha(senha);

                let barra = $('#strength-bar');
                let texto = $('#strength-text');

                let porcentagem = (forca / 5) * 100;
                barra.css('width', porcentagem + '%');

                if (forca <= 2) {
                    barra.css('background', '#ef4444');
                    texto.text('Senha fraca').css('color', '#ef4444');
                } else if (forca <= 4) {
                    barra.css('background', '#f59e0b');
                    texto.text('Senha média').css('color', '#f59e0b');
                } else {
                    barra.css('background', '#22c55e');
                    texto.text('Senha forte').css('color', '#22c55e');
                }
            });

            // ==============================
            // SHOW / HIDE PASSWORD
            // ==============================
            $('#password, #password_confirmation').after(
                '<span class="toggle-password" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;"><i class="fas fa-eye"></i></span>'
            );

            $(document).on('click', '.toggle-password', function() {
                let input = $(this).siblings('input');
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

            // ==============================
            // SUBMIT
            // ==============================
            $('#form-register').on('submit', function(e) {
                e.preventDefault();

                $('.error-message').hide();
                $('.form-control').removeClass('is-invalid');

                let cpf = $('#cpf').val();
                let senha = $('#password').val();
                let confirmar = $('#password_confirmation').val();
                let forca = verificarForcaSenha(senha);

                let erro = false;

                if (!validarCPF(cpf)) {
                    exibirErro('cpf', 'CPF inválido.');
                    erro = true;
                }

                if (senha !== confirmar) {
                    exibirErro('password_confirmation', 'As senhas não coincidem.');
                    erro = true;
                }

                if (forca < 5) {
                    exibirErro('password',
                        'Use no mínimo 8 caracteres, letra maiúscula, minúscula, número e símbolo.');
                    erro = true;
                }

                if (erro) return;

                const btn = $('#btn-submit');
                const originalText = btn.html();
                btn.html('<i class="fas fa-circle-notch fa-spin"></i> Criando conta...').prop('disabled',
                    true);

                $.ajax({
                    url: '{{ url('api/register') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        nome: $('#nome').val(),
                        email: $('#email').val(),
                        cpf: cpf.replace(/\D/g, ''),
                        password: senha,
                        password_confirmation: confirmar
                    }),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Conta criada!',
                            text: 'Cadastro realizado com sucesso.',
                            confirmButtonColor: '#2563eb'
                        }).then(() => window.location.href = '{{ route('login') }}');
                    },
                    error: function(xhr) {
                        btn.html(originalText).prop('disabled', false);

                        if (xhr.status === 422) {
                            const erros = xhr.responseJSON.errors;
                            for (const campo in erros) {
                                exibirErro(campo, erros[campo][0]);
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro no sistema',
                                text: 'Não foi possível completar o cadastro.'
                            });
                        }
                    }
                });
            });

        });
    </script>
</body>

</html>
