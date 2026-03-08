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
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Cliente -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="form-editar-cliente" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editar-id">
        <div class="mb-3">
          <label for="editar-nome" class="form-label">Nome</label>
          <input type="text" id="editar-nome" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="editar-email" class="form-label">Email</label>
          <input type="email" id="editar-email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="editar-cpf" class="form-label">CPF</label>
          <input type="text" id="editar-cpf" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="editar-password" class="form-label">Nova Senha</label>
          <input type="password" id="editar-password" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Pagamentos -->
<div class="modal fade" id="modalPagamentos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pagamentos do Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="tabela-pagamentos">
          <thead>
            <tr>
              <th>ID</th>
              <th>Descrição</th>
              <th>Valor</th>
              <th>Vencimento</th>
              <th>Status</th>
              <th>Ações</th>
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
<script src="{{ asset('js/clientes.js') }}"></script>
<script>
$(document).ready(function(){

    const token = localStorage.getItem('token');
    if(!token){
        Swal.fire('Atenção','Você precisa estar logado como admin','warning')
        .then(()=> window.location.href='{{ route("login") }}');
        return;
    }

    // Carrega clientes
    function carregarClientes(){
        $.ajax({
            url:'/api/clientes/listar',
            type:'GET',
            headers:{'Authorization':'Bearer '+token},
            success:function(res){
                const tbody = $('#tabela-clientes tbody'); tbody.empty();
                if(res.success){
                    res.data.forEach(c=>{
                        tbody.append(`
                        <tr>
                            <td>${c.id}</td>
                            <td>${c.nome}</td>
                            <td>${c.email}</td>
                            <td>${c.cpf}</td>
                            <td>${new Date(c.created_at).toLocaleString()}</td>
                            <td>
                                <button class="btn btn-sm btn-primary btn-editar" data-id="${c.id}" data-nome="${c.nome}" data-email="${c.email}" data-cpf="${c.cpf}">Editar</button>
                                <button class="btn btn-sm btn-danger btn-excluir" data-id="${c.id}">Excluir</button>
                                <button class="btn btn-sm btn-success btn-pagamentos" data-id="${c.id}">Pagamentos</button>
                            </td>
                        </tr>`);
                    });
                } else tbody.append('<tr><td colspan="6">Nenhum cliente cadastrado</td></tr>');
            }
        });
    }

    carregarClientes();

    // Excluir cliente
    $(document).on('click','.btn-excluir',function(){
        const id = $(this).data('id');
        Swal.fire({title:'Confirma a exclusão?',showCancelButton:true,confirmButtonText:'Sim'})
        .then(r=>{
            if(r.isConfirmed){
                $.ajax({
                    url:`/api/clientes/${id}`,
                    type:'DELETE',
                    headers:{'Authorization':'Bearer '+token},
                    success:()=>{ Swal.fire('Excluído','Cliente removido','success'); carregarClientes(); }
                });
            }
        });
    });

    // Abrir modal Editar
    $(document).on('click','.btn-editar',function(){
        $('#editar-id').val($(this).data('id'));
        $('#editar-nome').val($(this).data('nome'));
        $('#editar-email').val($(this).data('email'));
        $('#editar-cpf').val($(this).data('cpf'));
        $('#editar-password').val('');
        new bootstrap.Modal(document.getElementById('modalEditarCliente')).show();
    });

    // Salvar edição
    $('#form-editar-cliente').submit(function(e){
        e.preventDefault();
        const data={
            id:$('#editar-id').val(),
            nome:$('#editar-nome').val(),
            email:$('#editar-email').val(),
            cpf:$('#editar-cpf').val(),
            password:$('#editar-password').val()
        };
        $.ajax({
            url:'/api/clientes',
            type:'PUT',
            data:JSON.stringify(data),
            contentType:'application/json',
            headers:{'Authorization':'Bearer '+token},
            success:function(res){ Swal.fire('Sucesso',res.message,'success'); carregarClientes(); $('#modalEditarCliente').modal('hide'); },
            error:function(xhr){ Swal.fire('Erro',xhr.responseJSON?.message || 'Falha ao editar','error'); }
        });
    });

    // Abrir modal Pagamentos
    $(document).on('click','.btn-pagamentos',function(){
        const clienteId = $(this).data('id');
        const tbody = $('#tabela-pagamentos tbody'); tbody.empty();
        $.ajax({
            url:`/api/pagamentos/cliente/${clienteId}`,
            type:'GET',
            headers:{'Authorization':'Bearer '+token},
            success:function(res){
                if(res.success){
                    res.data.forEach(p=>{
                        tbody.append(`
                        <tr>
                            <td>${p.id}</td>
                            <td>${p.descricao}</td>
                            <td>${p.valor.toFixed(2)}</td>
                            <td>${new Date(p.vencimento).toLocaleDateString()}</td>
                            <td>${p.status}</td>
                            <td><!-- Botões editar/excluir se quiser --></td>
                        </tr>`);
                    });
                } else tbody.append('<tr><td colspan="6">Nenhum pagamento</td></tr>');
                new bootstrap.Modal(document.getElementById('modalPagamentos')).show();
            }
        });
    });

});
</script>
@endsection
