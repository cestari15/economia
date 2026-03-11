<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha - ECONOMIZZ</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #075985 0%, #2563eb 50%, #60a5fa 100%);
            --brand-blue: #2563eb;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --white: #ffffff;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
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
            text-align: center;
        }

        .logo-text {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--brand-blue);
            text-decoration: none;
            display: block;
            margin-bottom: 15px;
        }

        .logo-text span {
            color: #7dd3fc;
        }

        .auth-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--brand-blue);
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--brand-blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-send {
            width: 100%;
            background: var(--brand-blue);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-send:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="auth-container">
        <div class="auth-card">
            <a href="/" class="logo-text">CRO<span>NOS</span></a>
            <div class="auth-title">Definir Nova Senha</div>

            <form id="novaSenhaForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label class="form-label">E-mail</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control" placeholder="Seu e-mail" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nova Senha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Digite a nova senha" required>
                        <i class="fas fa-eye toggle-password" style="left: auto; right: 15px; cursor: pointer;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirmar Senha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-shield-alt"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="Confirme a senha" required>
                        <i class="fas fa-eye toggle-password" style="left: auto; right: 15px; cursor: pointer;"></i>
                    </div>
                </div>

                <button type="submit" class="btn-send" id="btn-submit">
                    Redefinir Senha
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // 1. Configuração de segurança CSRF (Obrigatório para Laravel)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // 2. Mostrar/Ocultar senha
            $('.toggle-password').click(function() {
                const input = $(this).siblings('input');
                const type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            // 3. Envio do Formulário
            $('#novaSenhaForm').submit(function(e) {
                e.preventDefault();

                // Validação de senhas iguais
                if ($('#password').val() !== $('#password_confirmation').val()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Atenção',
                        text: 'As senhas não coincidem!'
                    });
                    return;
                }

                const btn = $('#btn-submit');
                const originalText = btn.html();
                btn.html('<i class="fas fa-circle-notch fa-spin"></i> Processando...').prop('disabled',
                    true);

                $.ajax({
                    url: "{{ route('nova-senha') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Senha redefinida!',
                                text: response.message,
                                confirmButtonColor: '#2563eb'
                            }).then(() => window.location.href = "{{ route('login') }}");
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: response.message
                            });
                        }
                    },
                    error: function(err) {
                        btn.html(originalText).prop('disabled', false);
                        let msg = err.responseJSON?.message || 'Erro no servidor.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            html: msg
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
