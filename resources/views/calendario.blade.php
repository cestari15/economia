@extends('template')

@section('titulo', 'Calendário')

@section('conteudo')
<div class="card">
    <div class="card-header">
        <h5>Calendário</h5>
    </div>
    <div class="card-body">
        <div id="calendario-container" class="text-center">
            <div id="nav-buttons" class="my-3 d-flex justify-content-between">
                <button id="prev-month" class="btn btn-calendario"><< Mês Anterior</button>
                <h5 id="mes-ano"></h5>
                <button id="next-month" class="btn btn-calendario">Próximo Mês >></button>
            </div>
            <table class="table table-bordered" id="tabela-calendario">
                <thead>
                    <tr>
                        <th>Dom</th>
                        <th>Seg</th>
                        <th>Ter</th>
                        <th>Qua</th>
                        <th>Qui</th>
                        <th>Sex</th>
                        <th>Sáb</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .btn-calendario {
        background-color: #6f42c1;
        color: #fff;
        border: none;
        padding: 5px 15px;
        font-weight: bold;
    }
    .btn-calendario:hover {
        background-color: #5a32a3;
        color: #fff;
    }

    #tabela-calendario td {
        height: 60px;
        vertical-align: top;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    #tabela-calendario td:hover {
        background-color: #f0e6ff;
    }
    .evento-destaque {
        background-color: #d9b3ff;
        border-radius: 5px;
        padding: 2px 4px;
        font-weight: bold;
        font-size: 0.85em;
    }

    /* Inputs roxos */
    .custom-input {
        border: 1px solid #6f42c1 !important;
        color: #6f42c1 !important;
        font-weight: 500;
    }
    .custom-input::placeholder {
        color: #6f42c1 !important;
        opacity: 1;
    }

    /* Centraliza SweetAlert */
    .swal2-popup {
        display: flex !important;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        top: 50% !important;
        transform: translateY(-50%) !important;
    }

    /* Radios estilizados como caixinhas */
    .lembrar-radio {
        width: 18px;
        height: 18px;
        accent-color: #6f42c1;
    }
    .lembrar-container {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-top: 5px;
    }
    .lembrar-container label {
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    .lembrar-container span {
        color: #6f42c1;
    }
</style>

<script>
$(document).ready(function() {
    const meses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
    let hoje = new Date();
    let mes = hoje.getMonth();
    let ano = hoje.getFullYear();
    let eventos = [];

    const token = localStorage.getItem('token');

    function carregarEventos() {
        fetch('{{ url('api/eventos') }}', {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(res => res.json())
        .then(data => {
            eventos = data.data || [];
            gerarCalendario(ano, mes);
        })
        .catch(err => console.error(err));
    }

    function gerarCalendario(anoParam, mesParam) {
        const tabelaBody = $('#tabela-calendario tbody');
        tabelaBody.empty();

        const primeiroDia = new Date(anoParam, mesParam, 1).getDay();
        const totalDias = new Date(anoParam, mesParam+1, 0).getDate();
        $('#mes-ano').text(`${meses[mesParam]} / ${anoParam}`);

        let dia = 1;
        for(let i=0;i<6;i++){
            let tr = $('<tr></tr>');
            for(let j=0;j<7;j++){
                if(i===0 && j<primeiroDia){
                    tr.append('<td></td>');
                } else if(dia>totalDias){
                    tr.append('<td></td>');
                } else {
                    let td = $('<td></td>').text(dia);

                    // eventos do dia
                    let eventosDoDia = eventos.filter(ev=>{
                        let dataEv = new Date(ev.data);
                        return dataEv.getDate()===dia && dataEv.getMonth()===mesParam && dataEv.getFullYear()===anoParam;
                    });
                    if(eventosDoDia.length>0){
                        eventosDoDia.forEach(ev=>{
                            td.append(`<div class="evento-destaque">${ev.nome}</div>`);
                        });
                    }

                    td.click(()=> abrirModalEvento(dia, mesParam, anoParam));
                    tr.append(td);
                    dia++;
                }
            }
            tabelaBody.append(tr);
        }
    }

    function abrirModalEvento(dia, mesParam, anoParam){
        Swal.fire({
            title: 'Cadastrar Evento',
            html: `
                <div style="text-align:center;">
                    <label style="color:#6f42c1; font-weight:bold;">Nome do Evento</label>
                    <input id="nome-evento" class="swal2-input custom-input" placeholder="Digite o nome">

                    <div style="margin-top:10px; text-align:center;">
                        <label style="color:#6f42c1; font-weight:bold;">Lembrar todo mês?</label>
                        <div class="lembrar-container">
                            <label>
                                <input type="radio" name="lembrar" value="sim" class="lembrar-radio" style="margin-right:5px;">
                                <span>Sim</span>
                            </label>
                            <label>
                                <input type="radio" name="lembrar" value="nao" class="lembrar-radio" style="margin-right:5px;" checked>
                                <span>Não</span>
                            </label>
                        </div>
                    </div>

                    <label style="color:#6f42c1; font-weight:bold; margin-top:10px;">Quantidade de dias para lembrete</label>
                    <input type="number" id="dias-lembrete" class="swal2-input custom-input" placeholder="Ex: 5">
                </div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Salvar',
            preConfirm: () => {
                let lembrar = $('input[name="lembrar"]:checked').val() || 'nao';
                return {
                    nome: $('#nome-evento').val(),
                    lembrar_todo_mes: lembrar,
                    dias_antes: $('#dias-lembrete').val(),
                    data: `${anoParam}-${mesParam+1}-${dia}`
                }
            }
        }).then((result)=>{
            if(result.isConfirmed){
                fetch('{{ url("api/eventos") }}',{
                    method:'POST',
                    headers:{
                        'Authorization':'Bearer '+token,
                        'Content-Type':'application/json'
                    },
                    body: JSON.stringify(result.value)
                })
                .then(res=>res.json())
                .then(data=>{
                    if(data.status){
                        Swal.fire('Sucesso','Evento cadastrado','success');
                        carregarEventos();
                    } else Swal.fire('Erro',data.message,'error');
                })
                .catch(err=>Swal.fire('Erro','Erro ao cadastrar evento','error'));
            }
        });
    }

    // Navegação do calendário
    $('#prev-month').click(()=>{
        mes = mes===0 ? 11 : mes-1;
        if(mes===11) ano--;
        gerarCalendario(ano, mes);
    });
    $('#next-month').click(()=>{
        mes = mes===11 ? 0 : mes+1;
        if(mes===0) ano++;
        gerarCalendario(ano, mes);
    });

    carregarEventos();
});
</script>
@endsection
