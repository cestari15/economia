@extends('template')

@section('titulo', 'Usuários Cadastrados')

@section('conteudo')
<div class="card card-authentication1 mx-auto my-5">
    <div class="card-body">
        <div class="card-content p-2">
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" class="logo-icon" alt="logo">
            </div>
            <div class="card-title text-uppercase text-center py-3">Usuários Cadastrados</div>

            <div class="table-responsive">
                <table class="table table-striped" id="tabela-clientes">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>CPF</th>
                            <th>Data de Cadastro</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    const token = localStorage.getItem('token');
    if(!token){
        Swal.fire('Atenção','Você precisa estar logado como admin','warning')
        .then(()=> window.location.href='{{ route("login") }}');
        return;
    }

    fetch('{{ url("api/clientes") }}', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            const tbody = $('#tabela-clientes tbody');
            tbody.empty();
            data.data.forEach(c => {
                tbody.append(`
                    <tr>
                        <td>${c.id}</td>
                        <td>${c.nome}</td>
                        <td>${c.email}</td>
                        <td>${c.cpf}</td>
                        <td>${new Date(c.created_at).toLocaleString()}</td>
                    </tr>
                `);
            });
        } else {
            Swal.fire('Erro', data.message || 'Não foi possível carregar os usuários','error');
        }
    })
    .catch(err => console.error(err));
});
</script>
@endsection
