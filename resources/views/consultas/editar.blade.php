
@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/consultas.css') }}">
@vite(['resources/js/pages/consultastextarea.js'])

@section('content')
<br>
<div class="section-container">
    <div class="formulario-agregar-container">
        <div class="informacion-header">
            <h3>Editar Consulta</h3>
            <a href="{{ route('consultas.lista') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de Consultas</a>
        </div>
        <div class="formulario-agregar">
            <h3>Editar Consulta</h3>
            <form method="POST" action="{{ route('consultas.update', $consulta->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="paciente_id" value="{{ $consulta->paciente->id }}">
                <input type="hidden" name="doctor_id" value="{{ $consulta->doctor->id }}">

                <!-- Información del Paciente y Doctor -->
                <div class="section">
                    <h3 class="section-title"><ion-icon name="information-circle-outline"></ion-icon> Información de la Consulta</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="nombre_paciente">Nombre del Paciente</label>
                            <input type="text" id="nombre_paciente" name="nombre_paciente" value="{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}" readonly class="input-field"/>
                        </div>
                        <div>
                            <label for="nombre_doctor">Nombre del Doctor</label>
                            @if(isset($consulta->doctor))
                                <input type="text" id="nombre_doctor" name="nombre_doctor" value="{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}" readonly class="input-field"/>
                            @else
                                <select id="nombre_doctor" name="doctor_id" class="input-field">
                                    <option value="">Seleccione un doctor</option>
                                    @foreach($doctores as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->nombres }} {{ $doctor->apellidos }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div>
                            <label for="fecha_consulta">Fecha de la Cita</label>
                            <input type="text" id="fecha_consulta" name="fecha_consulta" value="{{ $consulta->created_at->format('Y-m-d') }}" readonly class="input-field"/>
                        </div>
                        <div>
                            <label for="hora_consulta">Hora de la Cita</label>
                            <input type="text" id="hora_consulta" name="hora_consulta" value="{{ $consulta->created_at->format('H:i') }}" readonly class="input-field"/>
                        </div>
                    </div>
                </div>

                <!-- Signos vitales -->
                <div class="section" id="section-signos-vitales">
                    <h3 class="section-title" data-target="section-signos-vitales-content">
                        <ion-icon name="body-outline"></ion-icon> Signos vitales
                    </h3>
                    <div class="grid grid-cols-2 gap-4" id="section-signos-vitales-content">
                        <div>
                            <label for="talla">Talla (cm)</label>
                            <input type="number" id="talla" name="talla" value="{{ $consulta->signosVitales->first()->talla }}" required class="input-field"/>
                        </div>
                        <div>
                            <label for="temperatura">Temperatura (°C)</label>
                            <input type="number" id="temperatura" name="temperatura" value="{{ $consulta->signosVitales->first()->temperatura }}" required class="input-field"/>
                        </div>
                        <div>
                            <label for="frecuencia_cardiaca">Frecuencia cardíaca (bpm)</label>
                            <input type="number" id="frecuencia_cardiaca" name="frecuencia_cardiaca" value="{{ $consulta->signosVitales->first()->frecuencia_cardiaca }}" required class="input-field"/>
                        </div>
                        <div>
                            <label for="saturacion_oxigeno">Saturación de oxígeno (%)</label>
                            <input type="number" id="saturacion_oxigeno" name="saturacion_oxigeno" value="{{ $consulta->signosVitales->first()->saturacion_oxigeno }}" required class="input-field"/>
                        </div>
                    </div>
                </div>

                <!-- Motivo de la consulta -->
                <div class="section" id="section-motivo-consulta">
                    <h3 class="section-title" data-target="section-motivo-consulta-content">
                        <ion-icon name="help-outline"></ion-icon> Motivo de la consulta
                    </h3>
                    <div id="section-motivo-consulta-content">
                        <textarea id="motivo_consulta" name="motivo_consulta" class="input-field">{{ $consulta->motivo_consulta }}</textarea>
                    </div>
                </div>

                <!-- Notas de padecimiento -->
                <div class="section" id="section-notas-padecimiento">
                    <h3 class="section-title" data-target="section-notas-padecimiento-content">
                        <ion-icon name="book-outline"></ion-icon> Notas de padecimiento
                    </h3>
                    <div id="section-notas-padecimiento-content" class="section-content">
                        <textarea id="notas_padecimiento" name="notas_padecimiento" class="input-field">{{ $consulta->notas_padecimiento }}</textarea>
                    </div>
                </div>

                <!-- Receta -->
                <div class="section" id="section-receta">
                    <h3 class="section-title" data-target="section-receta-content">
                        <ion-icon name="medkit-outline"></ion-icon> Receta
                    </h3>
                    <div id="section-receta-content" class="section-content">
                        <div id="receta-fields-container" class="flex flex-wrap gap-4 align-middle">
                        <div class="flex-1 flex items-center">
                            <button type="button" id="addTimeButton" class="add"><ion-icon name="add-outline"></ion-icon></button>
                        </div>
                            @foreach($consulta->recetas as $index => $receta)
                                <div class="receta-field-group flex w-full gap-4">
                                    <div class="flex-1">
                                        <label for="medicacion">Medicación</label>
                                        <input type="text" id="medicacion" name="medicacion[]" value="{{ $receta->medicacion }}" required class="input-field"/>
                                    </div>
                                    <div class="flex-1">
                                        <label for="cantidad_medicamento">Cantidad</label>
                                        <input type="number" id="cantidad_medicamento" name="cantidad_medicamento[]" value="{{ $receta->cantidad_medicamento }}" required class="input-field"/>
                                    </div>
                                    <div class="flex-1">
                                        <label for="frecuencia_medicamento">Frecuencia</label>
                                        <input type="text" id="frecuencia_medicamento" name="frecuencia_medicamento[]" value="{{ $receta->frecuencia_medicamento }}" required class="input-field"/>
                                    </div>
                                    <div class="flex-1">
                                        <label for="duracion_medicamento">Duración</label>
                                        <input type="text" id="duracion_medicamento" name="duracion_medicamento[]" value="{{ $receta->duracion_medicamento }}" required class="input-field"/>
                                    </div>
                                    <div class="flex-1 flex items-center">
                                        <button type="button" id="addTimeButton" class="add"  style="margin-right: 10px;"><ion-icon name="add-outline"></ion-icon></button>
                                        <button type="button" class="removeButton add"><ion-icon name="trash-outline"></ion-icon></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <textarea id="notas_receta" name="notas_receta[]" class="input-field" placeholder="Agregar notas...">{{ $consulta->recetas->pluck('notas_receta')->implode(' ') }}</textarea>
                    </div>
                </div>

                <!-- Servicios -->
                <div class="section" id="section-servicios">
                    <h3 class="section-title" data-target="section-servicios-content">
                        <ion-icon name="medkit-outline"></ion-icon> Servicios
                    </h3>
                    <div id="section-servicios-content" class="section-content">
                        <div id="servicios-fields-container" class="flex flex-wrap gap-4 align-middle">
                        <div class="flex-1 flex items-center">
                            <button type="button" id="addServicioButton" class="add"  style="margin-right: 10px;"><ion-icon name="add-outline"></ion-icon></button>
                        </div>
                            @foreach($consulta->serviciosConsulta as $index => $servicioConsulta)
                                <div class="servicios-field-group flex w-full gap-4">
                                    <div class="flex-1">
                                        <label for="servicio">Servicio</label>
                                        <select id="servicio" name="servicio[]" class="input-field servicio-select" required>
                                            <option value="">Seleccione un servicio</option>
                                            @foreach($servicios as $servicio)
                                                <option value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}" {{ $servicio->id == $servicioConsulta->servicio_id ? 'selected' : '' }}>
                                                    {{ $servicio->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <label for="cantidad_servicio">Cantidad</label>
                                        <input type="number" id="cantidad_servicio" name="cantidad_servicio[]" class="input-field" value="1" required/>
                                    </div>
                                    <div class="flex-1">
                                        <label for="precio">Precio</label>
                                        <input type="number" id="precio" name="precio[]" value="{{ $servicioConsulta->precio }}" required class="input-field" readonly/>
                                    </div>
                                    <div class="flex-1 flex items-center">
                                        <button type="button" id="addServicioButton" class="add"  style="margin-right: 10px;"><ion-icon name="add-outline"></ion-icon></button>
                                        <button type="button" class="removeButton add"><ion-icon name="trash-outline"></ion-icon></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <textarea id="notas_servicio" name="notas_servicio[]" class="input-field" placeholder="Agregar notas...">{{ $consulta->serviciosConsulta->pluck('notas_servicio')->implode(' ') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn">Actualizar</button>
            </form>
        </div>
    </div>
</div>


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
