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
        droppable: true,
        events: '/citas-eventos',
        dateClick: function(info) {
            var selectedDate = info.dateStr;
            document.getElementById('selected-date').innerText = selectedDate;
            fetchCitas(selectedDate);
        }
    });
    calendar.render();
});

function fetchCitas(date) {
    fetch(`/citas-dia?fecha=${date}`)
        .then(response => response.json())
        .then(data => {
            var citasTableBody = document.querySelector('.appointment-list tbody');
            citasTableBody.innerHTML = '';

            data.citas.forEach(cita => {
                var row = document.createElement('tr');

                row.innerHTML = `
                    <td>${cita.id}</td>
                    <td>${cita.doctor.nombres}</td>
                    <td>${cita.paciente.nombres}</td>
                    <td>${cita.hora}</td>
                    <td>${cita.estado}</td>
                `;

                citasTableBody.appendChild(row);
            });
        });
}
