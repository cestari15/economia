<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>

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
                <div class="text-center mb-3">
                    <img src="{{ asset('images/logo.png') }}" class="logo-icon mb-2" alt="logo">
                    <h5 class="text-white">Meu Perfil</h5>
                </div>

                <form id="form-profile">
                    <div class="form-group">
                        <label for="nome" class="sr-only">Nome</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" id="nome" name="nome" class="form-control input-shadow"
                                placeholder="Seu nome" required>
                            <div class="form-control-position"><i class="icon-user"></i></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <div class="position-relative has-icon-right">
                            <input type="email" id="email" name="email" class="form-control input-shadow"
                                placeholder="Seu email" required disabled>
                            <div class="form-control-position"><i class="icon-envelope"></i></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cpf" class="sr-only">CPF</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" id="cpf" name="cpf" class="form-control input-shadow"
                                placeholder="000.000.000-00" disabled>
                            <div class="form-control-position"><i class="icon-credit-card"></i></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="sr-only">Nova Senha</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" id="password" name="password" class="form-control input-shadow"
                                placeholder="Digite uma nova senha (opcional)">
                            <div class="form-control-position"><i class="icon-lock"></i></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-light btn-block">Salvar alterações</button>
                </form>
            </div>
        </div>

        <div class="card-footer text-center py-3">
            <button id="logout-btn" class="btn btn-danger btn-sm">
                <i class="icon-logout"></i> Logout
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');

            if (!token) {
                Swal.fire('Erro', 'Você precisa estar logado.', 'error')
                    .then(() => window.location.href = '{{ route("login") }}');
                return;
            }

            // Carregar dados do usuário
            fetch('{{ url("api/user") }}', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                $('#nome').val(data.nome);
                $('#email').val(data.email);
                $('#cpf').val(data.cpf);
            })
            .catch(() => Swal.fire('Erro', 'Não foi possível carregar seus dados.', 'error'));

            // Atualizar perfil
            $('#form-profile').on('submit', function(e) {
                e.preventDefault();
                const dados = {
                    nome: $('#nome').val(),
                    password: $('#password').val()
                };

                fetch('{{ url("api/user/update") }}', {
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dados)
                })
                .then(res => res.json())
                .then(response => {
                    if (response.status) {
                        Swal.fire('Sucesso', 'Perfil atualizado!', 'success');
                    } else {
                        Swal.fire('Erro', response.message || 'Erro ao atualizar perfil.', 'error');
                    }
                })
                .catch(() => Swal.fire('Erro', 'Erro ao atualizar perfil.', 'error'));
            });

            // Logout
            $('#logout-btn').click(function() {
                fetch('{{ url("logout") }}', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).finally(() => {
                    localStorage.removeItem('token');
                    window.location.href = '{{ route("login") }}';
                });
            });
        });
    </script>

</body>
</html>
