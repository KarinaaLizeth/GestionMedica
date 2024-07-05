document.addEventListener('DOMContentLoaded', function() {
    // Obtiene el elemento del DOM donde se mostrará el calendario
    var calendarEl = document.getElementById('calendar');

    // Inicializa un nuevo calendario de FullCalendar en el elemento seleccionado
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es', // Establece el idioma del calendario a español
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
        editable: true, // permite la edición de eventos
        droppable: true, // permite arrastrar y soltar eventos
        events: '/citas-eventos', // URL para obtener los eventos del calendario
        // maneja el evento cuando se hace clic en una fecha
        dateClick: function(info) {
            var selectedDate = info.dateStr; // obtiene la fecha seleccionada en formato de cadena
            document.getElementById('selected-date').innerText = selectedDate; // uestra la fecha seleccionada en el elemento correspondiente
            fetchCitas(selectedDate); // llama a la función para obtener las citas del día seleccionado
        }
    });

    calendar.render();
});

// obtener las citas de una fecha específica y mostrarlas en una tabla
function fetchCitas(date) {
    // solicitud fetch para obtener las citas del día especificado
    fetch(`/citas-dia?fecha=${date}`)
        .then(response => response.json()) // convierte la respuesta a JSON
        .then(data => {
            var citasTableBody = document.querySelector('.appointment-list tbody'); 
            citasTableBody.innerHTML = ''; 

            // recorrer cada cita y crea una fila en la tabla para cada una
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
