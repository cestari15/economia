<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-style.css') }}" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="bg-theme bg-theme1">

    <div class="card card-authentication1 mx-auto my-5">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="text-center">
                    <img src="{{ asset('images/logo.png') }}" class="logo-icon" alt="logo">
                </div>
                <div class="card-title text-uppercase text-center py-3">Entre com sua conta</div>

                <!-- Formulário -->
                <form id="form-login">
                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <div class="position-relative has-icon-right">
                            <input type="email" id="email" name="email" class="form-control input-shadow"
                                placeholder="Digite seu email" required>
                            <div class="form-control-position"><i class="icon-user"></i></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="sr-only">Senha</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" id="password" name="password" class="form-control input-shadow"
                                placeholder="Digite sua senha" required>
                            <div class="form-control-position"><i class="icon-lock"></i></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <div class="icheck-material-white">
                                <input type="checkbox" id="remember" />
                                <label for="remember">Lembre-se</label>
                            </div>
                        </div>
                        <div class="form-group col-6 text-right">
                            <a href="{{ route('esqueci-senha') }}">Esqueceu a senha?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-light btn-block">Entrar</button>
                </form>

                <div class="card-footer text-center py-3">
                    <p class="text-warning mb-0">Não tem conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Login AJAX -->
    <script>
        $(document).ready(function() {
            $('#form-login').on('submit', function(e) {
                e.preventDefault();

                let dados = {
                    email: $('#email').val(),
                    password: $('#password').val()
                };

                $.ajax({
                    url: '{{ url("api/login") }}',
                    type: 'POST',
                    data: JSON.stringify(dados),
                    contentType: 'application/json',
                    success: function(response) {
                        if(response.status) {
                            // Salva token e usuário no localStorage
                            localStorage.setItem('token', response.token);
                            localStorage.setItem('user', JSON.stringify(response.user));

                            let usuario = response.user;
                            let mensagem = usuario.tipo === 'admin' 
                                ? 'Login de administrador realizado!' 
                                : 'Login realizado com sucesso!';

                            Swal.fire({
                                icon: 'success',
                                title: mensagem,
                                text: 'Você será redirecionado...',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '{{ route("home") }}';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: response.message || 'Erro ao fazer login.'
                            });
                        }
                    },
                    error: function(err) {
                        if(err.responseJSON?.errors) {
                            let messages = '';
                            for(const key in err.responseJSON.errors){
                                messages += `${err.responseJSON.errors[key][0]}<br>`;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro de validação',
                                html: messages
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: err.responseJSON?.message || 'Erro ao fazer login.'
                            });
                        }
                    }
                });
            });
        });
    </script>

</body>
</html>
