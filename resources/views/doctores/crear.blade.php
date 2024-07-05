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
        <h3>Agregar Doctor</h3>
        <form id="doctorForm" method="POST" action="{{ route('doctores.store') }}">
            @csrf

            <!-- Nombres -->
            <div>
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" value="{{ old('nombres') }}" required />
            </div>

            <!-- Apellidos -->
            <div>
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required />
            </div>

            <!-- Email -->
            <div class="col-span-1 md:col-span-2">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required />
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
                <input type="number" id="telefono" name="telefono" value="{{ old('telefono') }}" required />
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
                <input type="number" id="precio_consulta" name="precio_consulta" value="{{ old('precio_consulta') }}" required />
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
                    <label><input type="checkbox" id="domingo" name="dias_disponibles[]" value="Domingo" {{ is_array(old('dias_disponibles')) && in_array('Domingo', old('dias_disponibles')) ? 'checked' : '' }}> Dom</label>
                    <label><input type="checkbox" id="lunes" name="dias_disponibles[]" value="Lunes" {{ is_array(old('dias_disponibles')) && in_array('Lunes', old('dias_disponibles')) ? 'checked' : '' }}> Lun</label>
                    <label><input type="checkbox" id="martes" name="dias_disponibles[]" value="Martes" {{ is_array(old('dias_disponibles')) && in_array('Martes', old('dias_disponibles')) ? 'checked' : '' }}> Mar</label>
                    <label><input type="checkbox" id="miercoles" name="dias_disponibles[]" value="Miércoles" {{ is_array(old('dias_disponibles')) && in_array('Miércoles', old('dias_disponibles')) ? 'checked' : '' }}> Mié</label>
                    <label><input type="checkbox" id="jueves" name="dias_disponibles[]" value="Jueves" {{ is_array(old('dias_disponibles')) && in_array('Jueves', old('dias_disponibles')) ? 'checked' : '' }}> Jue</label>
                    <label><input type="checkbox" id="viernes" name="dias_disponibles[]" value="Viernes" {{ is_array(old('dias_disponibles')) && in_array('Viernes', old('dias_disponibles')) ? 'checked' : '' }}> Vie</label>
                    <label><input type="checkbox" id="sabado" name="dias_disponibles[]" value="Sábado" {{ is_array(old('dias_disponibles')) && in_array('Sábado', old('dias_disponibles')) ? 'checked' : '' }}> Sáb</label>
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
