@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/crear.css') }}">

@section('content')
<br>
<div class="formulario-agregar-container">
    <div class="informacion-header">
        <h3>Información</h3>
        <a href="{{ route('doctores.index') }}">
            <ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de Doctores
        </a>
    </div>
    <div class="formulario-agregar">
        <h3>Agregar Doctor</h3>
        <form id="doctorForm" method="POST" action="{{ route('doctores.store') }}">
            @csrf

            <!-- Nombres -->
            <div>
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" required />
            </div>

            <!-- Apellidos -->
            <div>
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" required />
            </div>

            <!-- Email -->
            <div class="col-span-1 md:col-span-2">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" required />
            </div>

            <!-- Password -->
            <div>
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required />
            </div>

            <!-- Repeat Password -->
            <div>
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required />
            </div>

            <!-- Telefono -->
            <div>
                <label for="telefono">Telefono</label>
                <input type="number" id="telefono" name="telefono" required />
            </div>

            <!-- Especialidad -->
            <div>
                <label for="especialidad">Especialidad</label>
                <select id="especialidad" name="especialidad" title="Selecciona una especialidad">
                    <option value="cardiologia">Cardiología</option>
                    <option value="prediatria">Pediatría</option>
                    <option value="oncologia">Oncología</option>
                    <option value="neurologa">Neurología</option>
                    <option value="dermatologia">Dermatología</option>
                </select>
            </div>

            <!-- Precio consulta -->
            <div>
                <label for="precio_consulta">Precio Consulta</label>
                <input type="number" id="precio_consulta" name="precio_consulta" required />
            </div>

            <div>
            <label for="duracion_cita">Tiempo de citas(en minutos)</label>
            <select id="duracion_cita" name="duracion_cita">
                <?php for ($i = 0; $i <= 60; $i += 10): ?>
                    <option value="<?= $i; ?>"><?= $i; ?> minutos</option>
                <?php endfor; ?>
            </select>
            </div>
            
            <!-- Días Disponibles -->
            <div >
                <label for="dias_disponibles">Días disponibles</label>
                <div class="dias-disponibles">
                    <label><input type="checkbox" id="domingo" name="dias_disponibles[]" value="Domingo"> Dom</label>
                    <label><input type="checkbox" id="lunes" name="dias_disponibles[]" value="Lunes"> Lun</label>
                    <label><input type="checkbox" id="martes" name="dias_disponibles[]" value="Martes"> Mar</label>
                    <label><input type="checkbox" id="miercoles" name="dias_disponibles[]" value="Miércoles"> Mié</label>
                    <label><input type="checkbox" id="jueves" name="dias_disponibles[]" value="Jueves"> Jue</label>
                    <label><input type="checkbox" id="viernes" name="dias_disponibles[]" value="Viernes"> Vie</label>
                    <label><input type="checkbox" id="sabado" name="dias_disponibles[]" value="Sábado"> Sáb</label>
                </div>
            </div>

            <!-- Tiempo Disponible -->
            <div class="col-span-1 md:col-span-2">
                <label for="available_time">Horario</label>
        
                <div id="timeContainer">
                    <div class="time-input">
                        <label for="available_time_from">De:</label>
                        <input type="time" id="available_time_from" name="available_time_from[]" required />
                    </div>
                    <div class="time-input">
                        <label for="available_time_to">A:</label>
                        <input type="time" id="available_time_to" name="available_time_to[]" required />
                    </div>
                </div>
            </div>

            <button type="button" id="addTimeButton" class="add-time-btn">Agregar Horario</button>

            <button type="submit">Registrar</button>
        </form>
    </div>
</div>
<br><br>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addTimeButton').addEventListener('click', function() {
        var timeContainer = document.getElementById('timeContainer');

        // Crear el contenedor principal para los nuevos campos de tiempo y el botón de eliminación
        var timeInputContainer = document.createElement('div');
        timeInputContainer.classList.add('time-input-container');

        // Crear el sub-contenedor para los campos de tiempo
        var timeInputs = document.createElement('div');
        timeInputs.classList.add('time-input');

        // Clonar los elementos de tiempo "De"
        var fromLabel = document.createElement('label');
        fromLabel.textContent = 'De:';
        timeInputs.appendChild(fromLabel);

        var fromInput = document.createElement('input');
        fromInput.setAttribute('type', 'time');
        fromInput.setAttribute('name', 'available_time_from[]');
        fromInput.setAttribute('required', true);
        timeInputs.appendChild(fromInput);

        // Clonar los elementos de tiempo "A"
        var toLabel = document.createElement('label');
        toLabel.textContent = 'A:';
        timeInputs.appendChild(toLabel);

        var toInput = document.createElement('input');
        toInput.setAttribute('type', 'time');
        toInput.setAttribute('name', 'available_time_to[]');
        toInput.setAttribute('required', true);
        timeInputs.appendChild(toInput);

        // Añadir el sub-contenedor de campos de tiempo al contenedor principal
        timeInputContainer.appendChild(timeInputs);

        // Crear el contenedor para el botón de eliminación
        var deleteButtonContainer = document.createElement('div');
        deleteButtonContainer.classList.add('delete-button-container');

        // Crear el botón de eliminación
        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.innerHTML = '<ion-icon name="close-outline"></ion-icon>';

        // Añadir evento para eliminar el conjunto de campos
        deleteButton.addEventListener('click', function() {
            timeContainer.removeChild(timeInputContainer);
        });

        // Añadir el botón de eliminación al contenedor del botón
        deleteButtonContainer.appendChild(deleteButton);

        // Añadir el contenedor del botón al contenedor principal
        timeInputContainer.appendChild(deleteButtonContainer);

        // Añadir los nuevos campos al contenedor principal
        timeContainer.appendChild(timeInputContainer);
    });
});
</script>