document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const fechaInput = document.getElementById('fecha');
    const horariosContainer = document.getElementById('horarios');
    const citasContainer = document.getElementById('citas');
    const horaInput = document.getElementById('hora');

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
                            mostrarCitasDisponibles(horario.hora_inicio, horario.hora_fin, data.duracion_cita);
                        });

                        label.appendChild(input);
                        label.appendChild(document.createTextNode(`${horario.hora_inicio} to ${horario.hora_fin}`));
                        horariosContainer.appendChild(label);
                    });
                });
        }
    }

    function mostrarCitasDisponibles(horaInicio, horaFin, duracionCita) {
        const inicio = new Date(`1970-01-01T${horaInicio}Z`);
        const fin = new Date(`1970-01-01T${horaFin}Z`);
        const duracion = duracionCita * 60 * 1000; // Duración de la cita en milisegundos
        citasContainer.innerHTML = '';
        document.getElementById('citas-container').style.display = 'block';

        for (let time = inicio; time < fin; time = new Date(time.getTime() + duracion)) {
            const endTime = new Date(time.getTime() + duracion);
            if (endTime > fin) break;

            const label = document.createElement('label');
            label.classList.add('cita-label');

            const input = document.createElement('input');
            input.type = 'radio';
            input.name = 'cita';
            input.value = time.toISOString().substring(11, 16);
            input.classList.add('cita-radio');
            input.addEventListener('change', () => {
                horaInput.value = time.toISOString().substring(11, 16);
            });

            label.appendChild(input);
            label.appendChild(document.createTextNode(`${time.toISOString().substring(11, 16)} to ${endTime.toISOString().substring(11, 16)}`));
            citasContainer.appendChild(label);
        }
    }

    // Inicializar los horarios y citas disponibles al cargar la página
    fetchHorarios();
    doctorSelect.addEventListener('change', fetchHorarios);
    fechaInput.addEventListener('change', fetchHorarios);
});