@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/editar.css') }}">

@section('content')
<br>
<div class="formulario-editar-container">
    <div class="informacion-header">
        <h3>Información del Doctor</h3>
        <a href="{{ route('doctores.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de Doctores</a>
    </div>
    <div class="formulario-editar">
        <h3>Editar Doctor</h3>
        <form method="POST" action="{{ route('doctores.actualizar', $doctor->id) }}">
            @csrf
            @method('PUT')

            <!-- Nombres -->
            <div class="full-width">
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" value="{{ $doctor->nombres }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Apellidos -->
            <div class="full-width">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="{{ $doctor->apellidos }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Correo -->
            <div class="full-width">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" value="{{ $doctor->correo }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" value="{{ $doctor->telefono }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Especialidad -->
            <div>
                <label for="especialidad">Especialidad</label>
                <select id="especialidad" name="especialidad" title="Selecciona una especialidad">
                    <option value="cardiologia" {{ $doctor->especialidad == 'cardiologia' ? 'selected' : '' }}>Cardiología</option>
                    <option value="pediatria" {{ $doctor->especialidad == 'pediatria' ? 'selected' : '' }}>Pediatría</option>
                    <option value="oncologia" {{ $doctor->especialidad == 'oncologia' ? 'selected' : '' }}>Oncología</option>
                    <option value="neurologia" {{ $doctor->especialidad == 'neurologia' ? 'selected' : '' }}>Neurología</option>
                    <option value="dermatologia" {{ $doctor->especialidad == 'dermatologia' ? 'selected' : '' }}>Dermatología</option>
                </select>
            </div>

            <!-- Precio de consulta -->
            <div>
                <label for="precio_consulta">Precio de consulta</label>
                <input type="number" id="precio_consulta" name="precio_consulta" value="{{ $doctor->precio_consulta }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!--Duración cita-->
            <div>
                <label for="duracion_cita">Tiempo de citas (en minutos)</label>
                <select id="duracion_cita" name="duracion_cita">
                    @for ($i = 0; $i <= 60; $i += 10)
                        <option value="{{ $i }}" {{ $doctor->duracion_cita == $i ? 'selected' : '' }}>{{ $i }} minutos</option>
                    @endfor
                </select>
            </div>

            <!-- Días disponibles -->
            <div>
                <label for="dias_disponibles">Días disponibles</label>
                <div class="dias-disponibles">
                    @foreach (['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                        <label>
                            <input type="checkbox" name="dias_disponibles[]" value="{{ $dia }}" {{ in_array($dia, $doctor->diasTrabajo->pluck('dia')->toArray()) ? 'checked' : '' }}> {{ $dia }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Horarios disponibles -->
            <div>
                <label for="available_time">Horarios disponibles</label>
                <div id="timeContainer">
                    @foreach ($doctor->horarios as $horario)
                        <div class="time-input-container">
                            <div class="time-input">
                                <label for="available_time_from">De:</label>
                                <input type="time" name="available_time_from[]" value="{{ $horario->hora_inicio }}" required />
                            </div>
                            <div class="time-input">
                                <label for="available_time_to">A:</label>
                                <input type="time" name="available_time_to[]" value="{{ $horario->hora_fin }}" required />
                            </div>
                            <div class="delete-button-container">
                                <button type="button" class="delete-time-button"><ion-icon name="close-outline"></ion-icon></button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="addTimeButton" class="add-time-btn">Agregar Horario</button>
            </div>

            <button type="submit">Actualizar</button>
        </form>
    </div>
</div>
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

    // Agregar funcionalidad de eliminación a los botones de eliminación existentes
    document.querySelectorAll('.delete-time-button').forEach(button => {
        button.addEventListener('click', function() {
            var timeContainer = document.getElementById('timeContainer');
            var timeInputContainer = button.closest('.time-input-container');
            timeContainer.removeChild(timeInputContainer);
        });
    });
});
</script>
