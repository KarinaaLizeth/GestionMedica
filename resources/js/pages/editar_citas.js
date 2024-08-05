
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const fechaInput = document.getElementById('fecha');
    const horariosContainer = document.getElementById('horarios');
    const citasContainer = document.getElementById('citas');
    const horaInput = document.getElementById('hora');

    // Establecer el mínimo valor de la fecha como hoy
    const today = new Date().toISOString().split('T')[0];
    fechaInput.setAttribute('min', today);

    function fetchHorarios() {
        const doctorId = doctorSelect.value;
        const fecha = fechaInput.value;

        if (doctorId && fecha) {
            fetch(`/horarios-disponibles?doctor_id=${doctorId}&fecha=${fecha}`)
                .then(response => response.json())
                .then(data => {
                    horariosContainer.innerHTML = '';
                    citasContainer.innerHTML = '';
                    document.getElementById('citas-container').style.display = 'none';

                    const citasReservadas = data.citasReservadas; // Obtiene las citas ya reservadas

                    data.horarios.forEach(horario => {
                        const label = document.createElement('label');
                        label.classList.add('horario-label');

                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.name = 'horario';
                        input.value = `${horario.hora_inicio}-${horario.hora_fin}`;
                        input.classList.add('horario-radio');
                        input.addEventListener('change', () => {
                            horaInput.value = horario.hora_inicio;
                            mostrarCitasDisponibles(horario.hora_inicio, horario.hora_fin, data.duracion_cita, citasReservadas, fecha);
                            document.querySelectorAll('.horario-label').forEach(l => l.classList.remove('selected'));
                            label.classList.add('selected');
                        });

                        label.appendChild(input);
                        label.appendChild(document.createTextNode(`${horario.hora_inicio} to ${horario.hora_fin}`));
                        horariosContainer.appendChild(label);
                    });
                });
        }
    }

    /**
     * función que muestra los horarios de citas disponibles dentro de un horario específico
     * rango, excluyendo tiempos reservados, basado en parámetros de entrada.
     * horaInicio  representa la hora de inicio de la disponibilidad
     * citas en formato "HH:MM" (formato de 24 horas).
     *  horaFin  representa la hora de finalización de la disponibilidad de
     * citas o reservas. Se utiliza en la función mostrarCitasDisponibles para determinar la
     * rango de franjas horarias dentro de las cuales se pueden programar citas.
     * duracionCitarepresenta la duración de cada cita
     * en minutos. Este valor se utiliza para calcular la duración de cada cita en milisegundos.
     * dentro de la función mostrarCitasDisponibles.
     *  citasReservadas en mostrarCitasDisponibles
     * la función es un array que contiene los horarios de las citas reservadas. Esta matriz se utiliza para
     * comprobar si una franja horaria específica ya está reservada o no, para que solo se muestren las franjas horarias disponibles
     * se muestran para
     * fecha  representa la fecha para la cual se desean mostrar las citas
     *disponibles. Es una cadena que debe tener el formato 'AAAA-MM-DD', por ejemplo '2022-12-31'. Esta
     * fecha se utiliza para filtrar las citas disponibles en función de la fecha seleccionada.
     */

    function mostrarCitasDisponibles(horaInicio, horaFin, duracionCita, citasReservadas, fecha) {
        const inicio = new Date(`1970-01-01T${horaInicio}Z`);
        const fin = new Date(`1970-01-01T${horaFin}Z`);
        const duracion = duracionCita * 60 * 1000; // Duración de la cita en milisegundos
        const now = new Date();
        const selectedDate = new Date(`${fecha}T00:00:00`);
        citasContainer.innerHTML = '';
        document.getElementById('citas-container').style.display = 'block';

        let citasDisponibles = false;

        for (let time = inicio; time < fin; time = new Date(time.getTime() + duracion)) {
            const endTime = new Date(time.getTime() + duracion);
            if (endTime > fin) break;

            const timeString = time.toISOString().substring(11, 16);
            const fullDateTime = new Date(`${fecha}T${timeString}`);

            if (!citasReservadas.includes(timeString) && (selectedDate > now || (selectedDate.toDateString() === now.toDateString() && fullDateTime > now))) {
                const label = document.createElement('label');
                label.classList.add('cita-label');

                const input = document.createElement('input');
                input.type = 'radio';
                input.name = 'cita';
                input.value = timeString;
                input.classList.add('cita-radio');
                input.addEventListener('change', () => {
                    horaInput.value = timeString;
                    document.querySelectorAll('.cita-label').forEach(l => l.classList.remove('selected'));
                    label.classList.add('selected');
                });

                label.appendChild(input);
                label.appendChild(document.createTextNode(`${timeString} to ${endTime.toISOString().substring(11, 16)}`));
                citasContainer.appendChild(label);

                citasDisponibles = true;
            }
        }

        if (!citasDisponibles) {
            const noCitasMessage = document.createElement('label');
            noCitasMessage.textContent = 'No hay citas disponibles para este horario';
            citasContainer.appendChild(noCitasMessage);
        }
    }

    // Inicializar los horarios y citas disponibles al cargar la página
    fetchHorarios();
    doctorSelect.addEventListener('change', fetchHorarios);
    fechaInput.addEventListener('change', fetchHorarios);
});
