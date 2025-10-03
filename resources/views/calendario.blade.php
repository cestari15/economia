@extends('template')

@section('titulo', 'Calendário')

@section('conteudo')
<div class="container-fluid">
    <div class="card mt-3">
        <div class="card-header"><h5>Meu Calendário</h5></div>
        <div class="card-body"><div id="calendar"></div></div>
    </div>
</div>

<!-- Modal para criar evento -->
<div class="modal fade" id="eventoModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="form-evento">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Adicionar Evento</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" required>
          </div>
          <div class="form-group">
            <label for="data">Data</label>
            <input type="date" class="form-control" id="data" required>
          </div>
          <div class="form-group">
            <label for="dias_antes">Dias antes</label>
            <input type="number" class="form-control" id="dias_antes" value="0">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<link href="{{ asset('vendor/fullcalendar/main.min.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/fullcalendar/main.min.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar/locales-all.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('token'); // token do usuário
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
        dateClick: function(info) {
            $('#data').val(info.dateStr);
            $('#eventoModal').modal('show');
        },
        events: function(fetchInfo, successCallback) {
            fetch('/api/eventos', {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(resp => {
                successCallback(resp.data.map(e => ({
                    id: e.id,
                    title: e.title,
                    start: e.start,
                    allDay: true
                })));
            })
            .catch(err => console.log(err));
        }
    });

    calendar.render();

    $('#form-evento').on('submit', function(e) {
        e.preventDefault();
        const data = {
            title: $('#titulo').val(),
            start: $('#data').val(),
            reminder_days_before: $('#dias_antes').val()
        };

        fetch('/api/eventos', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(resp => {
            if(resp.status) {
                calendar.refetchEvents();
                $('#eventoModal').modal('hide');
                $('#form-evento')[0].reset();
                alert(resp.message || 'Evento criado!');
            } else {
                alert('Erro ao salvar evento.');
            }
        })
        .catch(err => console.log(err));
    });
});
</script>
@endsection
