@extends('template')

@section('titulo', 'Minhas Anotações')

@section('conteudo')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5>Cadastrar Anotação</h5>
        </div>
        <div class="card-body">
            <form id="form-anotacao">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome da anotação" required>
                    <small class="text-danger" id="error-nome"></small>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <input type="text" id="categoria" name="categoria" class="form-control" placeholder="Categoria" required>
                    <small class="text-danger" id="error-categoria"></small>
                </div>

                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input type="number" step="0.01" id="valor" name="valor" class="form-control" placeholder="Valor" required>
                    <small class="text-danger" id="error-valor"></small>
                </div>

                <div class="form-group">
                    <label for="data">Data</label>
                    <input type="date" id="data" name="data" class="form-control" required>
                    <small class="text-danger" id="error-data"></small>
                </div>

                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const token = localStorage.getItem('token');
    if (!token) {
        window.location.href = '{{ route("login") }}';
        return;
    }

    // Logout botão
    $('#logout-btn').click(function(e) {
        e.preventDefault();
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        window.location.href = '{{ route("login") }}';
    });

    // Submeter formulário
    $('#form-anotacao').on('submit', function(e) {
        e.preventDefault();

        // Limpa erros
        $('#error-nome, #error-categoria, #error-valor, #error-data').text('');

        const dados = {
            nome: $('#nome').val(),
            categoria: $('#categoria').val(),
            valor: $('#valor').val(),
            data: $('#data').val()
        };

        $.ajax({
            url: '{{ url("api/anotacoes/store") }}',
            type: 'POST',
            data: JSON.stringify(dados),
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function(response) {
                if(response.status) {
                    Swal.fire('Sucesso', response.message, 'success');
                    // Limpa formulário
                    $('#form-anotacao')[0].reset();
                } else {
                    Swal.fire('Erro', response.message || 'Erro ao cadastrar anotação', 'error');
                }
            },
            error: function(err) {
                if(err.responseJSON && err.responseJSON.errors) {
                    const errors = err.responseJSON.errors;
                    if(errors.nome) $('#error-nome').text(errors.nome[0]);
                    if(errors.categoria) $('#error-categoria').text(errors.categoria[0]);
                    if(errors.valor) $('#error-valor').text(errors.valor[0]);
                    if(errors.data) $('#error-data').text(errors.data[0]);
                } else {
                    Swal.fire('Erro', 'Erro ao cadastrar anotação', 'error');
                }
            }
        });
    });
});
</script>
@endsection
