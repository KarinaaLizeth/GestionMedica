@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/crear.css') }}">
@vite(['resources/js/pages/editar_citas.js'])
@section('content')
<br>
<div class="formulario-agregar-container">
    <div class="informacion-header">
        <h3>Información</h3>
        <a href="{{ route('citas.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de Citas</a>
    </div>
    <div class="formulario-agregar">
        <h3>Agendar Cita</h3>
        <form method="POST" action="{{ route('citas.store') }}">
            @csrf

            <!-- Paciente -->
            <div>
                <label for="paciente_id">Paciente</label>
                <select name="paciente_id" id="paciente_id" class="js-tom-select" value="{{ old('paciente_id') }}">
                    @foreach($pacientes as $paciente)
                      <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>{{ $paciente->nombres }} {{ $paciente->apellidos }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Doctor -->
            <div>
                <label for="doctor_id">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="js-tom-select" value="{{ old('doctor_id') }}">
                    @foreach($doctores as $doctor)
                      <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->nombres }} {{ $doctor->apellidos }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha -->
            <div>
              <label for="fecha">Fecha</label>
              <input type="date" name="fecha" id="fecha" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ old('fecha') }}" required />
            </div>

            <!-- Horarios Disponibles -->
            <div id="horarios-container">
                <label for="horarios">Horarios Disponibles</label>
                <div id="horarios" class="horarios-list"></div>
            </div>

            <!-- Citas Disponibles -->
            <div id="citas-container" style="display:none;">
                <label for="citas">Citas Disponibles</label>
                <div id="citas" class="citas-list"></div>
            </div>

            <!-- Hora -->
            <input type="hidden" name="hora" id="hora" value="{{ old('hora') }}" required />

            <button type="submit">Registrar</button>
        </form>
        
        <!-- Mostrar errores -->
        @if($errors->any())
            <div class="alert alert-danger mt-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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

@endsection