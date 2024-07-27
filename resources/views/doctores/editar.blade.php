
@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/crear.css') }}">
@vite(['resources/js/pages/crear_doctores.js'])

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
        <h3>Actualizar Doctor</h3>
        <form id="doctorForm" method="POST" action="{{ route('doctores.actualizar', $doctor->id) }}">
        @csrf
        @method('PUT')

            <!-- Nombres -->
            <div>
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" value="{{ $doctor->nombres }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Apellidos -->
            <div>
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="{{ $doctor->apellidos }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Email -->
            <div class="col-span-1 md:col-span-2">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" value="{{ $doctor->correo }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Telefono -->
            <div>
                <label for="telefono">Telefono</label>
                <input type="number" id="telefono" name="telefono" value="{{ $doctor->telefono }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
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

            <!-- Precio consulta -->
            <div>
                <label for="precio_consulta">Precio Consulta</label>
                <input type="number" id="precio_consulta" name="precio_consulta" value="{{ $doctor->precio_consulta }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <div>
            <label for="duracion_cita">Tiempo de citas(en minutos)</label>
            <select id="duracion_cita" name="duracion_cita">
                    @for ($i = 0; $i <= 60; $i += 10)
                        <option value="{{ $i }}" {{ $doctor->duracion_cita == $i ? 'selected' : '' }}>{{ $i }} minutos</option>
                    @endfor
                </select>
            </div>
            
            <!-- Días Disponibles -->
            <div >
                <label for="dias_disponibles">Días disponibles</label>
                <div class="dias-disponibles">
                    @foreach (['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                        <label>
                            <input type="checkbox" name="dias_disponibles[]" value="{{ $dia }}" {{ in_array($dia, $doctor->diasTrabajo->pluck('dia')->toArray()) ? 'checked' : '' }}> {{ $dia }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Tiempo Disponible -->
            <div class="col-span-1 md:col-span-2">
                <label for="available_time">Horario</label>
                <div id="timeContainer">
                    @foreach ($doctor->horarios as $horario)
                        <div class="time-input">
                            <label for="available_time_from">De:</label>
                            <input type="time" id="available_time_from"  name="available_time_from[]" value="{{ $horario->hora_inicio }}" required />
                        </div>
                        <div class="time-input">
                            <label for="available_time_to">A:</label>
                            <input type="time"id="available_time_to" name="available_time_to[]" value="{{ $horario->hora_fin }}" required />
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="button" id="addTimeButton" class="add-time-btn">Agregar Horario</button>
            <button type="submit">Actualizar</button>
        </form>
    </div>
</div>
<br><br>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Errores de Validación',
            html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif

@endsection
