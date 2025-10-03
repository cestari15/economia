<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

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
                <div class="card-title text-uppercase text-center py-3">Crie sua conta</div>

                <!-- Formulário -->
                <form id="form-register">
                    <div class="form-group">
                        <label for="nome" class="sr-only">Nome</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" id="nome" name="nome" class="form-control input-shadow"
                                placeholder="Digite seu nome" required>
                            <div class="form-control-position"><i class="icon-user"></i></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <div class="position-relative has-icon-right">
                            <input type="email" id="email" name="email" class="form-control input-shadow"
                                placeholder="Digite seu email" required>
                            <div class="form-control-position"><i class="icon-envelope"></i></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cpf" class="sr-only">CPF</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" id="cpf" name="cpf" class="form-control input-shadow"
                                placeholder="Digite seu CPF" required maxlength="14">
                            <div class="form-control-position"><i class="icon-credit-card"></i></div>
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

                    <div class="form-group">
                        <label for="password_confirmation" class="sr-only">Confirmar Senha</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control input-shadow" placeholder="Confirme sua senha" required>
                            <div class="form-control-position"><i class="icon-lock"></i></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-light btn-block">Cadastrar</button>
                </form>

                <div class="card-footer text-center py-3">
                    <p class="text-warning mb-0">Já tem conta? <a href="{{ route('login') }}">Entre aqui</a></p>
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

    <!-- Cadastro AJAX -->
    <script>
        $(document).ready(function() {
            $('#form-register').on('submit', function(e) {
                e.preventDefault();

                let dados = {
                    nome: $('#nome').val(),
                    email: $('#email').val(),
                    cpf: $('#cpf').val().replace(/\D/g, ''), // remove pontos e traços
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val()
                };

                $.ajax({
                    url: '{{ url("api/register") }}',
                    type: 'POST',
                    data: JSON.stringify(dados),
                    contentType: 'application/json',
                    success: function(response) {
                        if(response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cadastro realizado!',
                                text: 'Você será redirecionado...',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '{{ route("login") }}';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: response.message || 'Erro ao cadastrar.'
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
                                text: err.responseJSON?.message || 'Erro ao cadastrar.'
                            });
                        }
                    }
                });
            });
        });
    </script>

</body>
</html>
