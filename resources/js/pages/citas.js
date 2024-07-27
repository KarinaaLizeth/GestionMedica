document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var modal = document.getElementById("citas-modal");
    var span = document.getElementsByClassName("close")[0];

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
        },
        eventClick: function(info) {
            var selectedDate = info.event.startStr.split('T')[0];
            document.getElementById('selected-date').innerText = selectedDate;
            fetchCitas(selectedDate);
            fetchCitasModal(selectedDate);
        },
        eventDrop: function(info) {
            var newDate = info.event.startStr.split('T')[0];
            var eventId = info.event.id;
            updateEventDate(eventId, newDate);
        }
    });

    calendar.render();

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
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

function fetchCitasModal(date) {
    fetch(`/citas-dia?fecha=${date}`)
        .then(response => response.json())
        .then(data => {
            var modalAppointmentListBody = document.getElementById('modal-appointment-list-body');
            var modalDate = document.getElementById('modal-date');
            modalDate.innerText = date;
            modalAppointmentListBody.innerHTML = '';

            data.citas.forEach(cita => {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${cita.id}</td>
                    <td>${cita.doctor.nombres}</td>
                    <td>${cita.paciente.nombres}</td>
                    <td>${cita.hora}</td>
                    <td>${cita.estado}</td>
                    <td>
                        ${cita.estado === 'En proceso' ? `
                            <a href="/citas/cambiarEstado/${cita.id}/completada" class="btn btn-success" style="margin-right: 10px;">Completar</a>
                            <a href="/citas/cambiarEstado/${cita.id}/cancelada" class="btn btn-danger" style="margin-right: 10px;">Cancelar</a>
                            <a href="/citas/editar/${cita.id}" class="btn btn-editar" style="margin-right: 10px;">Editar</a>
                            <a href="/consultas/crear?cita_id=${cita.id}" class="btn btn-consulta">Ir a consulta</a>
                        ` : `
                            <span class="badge badge-${cita.estado === 'completada' ? 'success' : 'danger'}">${cita.estado}</span>
                        `}
                    </td>
                `;
                modalAppointmentListBody.appendChild(row);
            });

            var modal = document.getElementById("citas-modal");
            modal.style.display = "block";
        });
}

function updateEventDate(eventId, newDate) {
    fetch(`/citas/${eventId}/actualizar-fecha`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ fecha: newDate })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Cita actualizada',
                text: 'La fecha de la cita ha sido actualizada exitosamente.',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al actualizar la fecha de la cita.',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al actualizar la fecha de la cita.',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
}
