@extends('layouts.app')

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset='utf-8' />
<script src="{{ asset('assets/fullcalendar/dist/index.global.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/citas.css') }}">
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'es',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        day: 'Día',
        list: 'Lista'
      },
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      drop: fACunction(arg) {
        // is the "remove after drop" checkbox checked?
        if (document.getElementById('drop-remove').checked) {
          // if so, remove the element from the "Draggable Events" list
          arg.draggedEl.parentNode.removeChild(arg.draggedEl);
        }
      }
    });
    calendar.render();
  });
</script>
</head>

@section('content')
<body>
  <div class="calendar-header">
    <a href="{{ route('citas.crear') }}" class="btn btn-primary"><ion-icon name="add-circle-outline"></ion-icon>Agregar Cita</a>
  </div>
  <div class="content-wrapper">
    <div id="calendar-wrap">
      <div id="calendar"></div>
    </div>
    <div class="appointment-list">
      <h3>Lista de Citas | <span id="selected-date">2024-06-07</span></h3>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Paciente</th>
            <th>Doctor</th>
            <th>Hora</th>
          </tr>
        </thead>
        <tbody>
          <!-- filas de las citas -->
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
@endsection
