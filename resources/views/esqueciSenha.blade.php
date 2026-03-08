<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - ECONOMIZZ</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #075985 0%, #2563eb 50%, #60a5fa 100%);
            --brand-blue: #2563eb;
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
            text-align: center;
        }

        .auth-header {
            margin-bottom: 25px;
        }

        .logo-text {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--brand-blue);
            text-decoration: none;
            letter-spacing: -1px;
            display: block;
            margin-bottom: 15px;
        }

        .logo-text span {
            color: #7dd3fc;
        }

        .auth-title {
            font-size: 1.1rem;
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .auth-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
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
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-send {
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
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }

        .btn-send:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 15px 20px -5px rgba(37, 99, 235, 0.4);
        }

        .auth-footer {
            margin-top: 30px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .auth-footer a {
            color: var(--brand-blue);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .auth-footer a:hover {
            text-decoration: underline;
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
                <a href="/" class="logo-text">ECONO<span>MIZZ</span></a>
                <div class="auth-title">Recuperar Senha</div>
                <p class="auth-subtitle">
                    Digite seu e-mail abaixo e enviaremos um link para você definir uma nova senha.
                </p>
            </div>

            <form id="recuperarSenhaForm">
                @csrf
                <div class="form-group">
                    <label class="form-label">E-mail Cadastrado</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope-open"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="exemplo@email.com" required>
                    </div>
                </div>

                <button type="submit" class="btn-send" id="btn-submit">Enviar Link de Redefinição</button>
            </form>

            <div class="auth-footer">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left"></i> Voltar para o Login
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#recuperarSenhaForm').submit(function(e) {
                e.preventDefault();

                const btn = $('#btn-submit');
                const originalText = btn.html();
                
                btn.html('<i class="fas fa-circle-notch fa-spin"></i> Enviando...').prop('disabled', true);

                $.ajax({
                    url: "{{ route('recuperar-senha') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);
                        
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'E-mail Enviado!',
                                text: 'Verifique sua caixa de entrada para continuar.',
                                confirmButtonColor: '#2563eb'
                            });
                            $('#email').val(''); // Limpa o campo
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ops!',
                                text: response.message || 'E-mail não encontrado.',
                                confirmButtonColor: '#2563eb'
                            });
                        }
                    },
                    error: function() {
                        btn.html(originalText).prop('disabled', false);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro no servidor. Tente novamente mais tarde.',
                            confirmButtonColor: '#2563eb'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>