@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/editar.css') }}">

@section('content')
<br>
<div class="formulario-editar-container">
    <div class="informacion-header">
        <h3>Información del Paciente</h3>
        <a href="{{ route('pacientes.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de pacientes</a>
    </div>
    <div class="formulario-editar">
        <h3>Editar Paciente</h3>
        <form method="POST" action="{{ route('pacientes.actualizar', $paciente->id) }}">
            @csrf
            @method('PUT')

            <!-- Nombres -->
            <div class="full-width"> 
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" value="{{ $paciente->nombres }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Apellidos -->
            <div class="full-width">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="{{ $paciente->apellidos }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Correo -->
            <div class="full-width">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" value="{{ $paciente->correo }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono">Teléfono</label>
                <input type="number" id="telefono" name="telefono" value="{{ $paciente->telefono }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Teléfono Emergencia -->
            <div>
                <label for="telefono_emergencia">Teléfono de Emergencia</label>
                <input type="number" id="telefono_emergencia" name="telefono_emergencia" value="{{ $paciente->telefono_emergencia }}" required />
            </div>

            <!-- Género -->
            <div>
                <label for="genero">Género</label>
                <div class="genero-opciones">
                    <label><input type="radio" name="genero" value="femenino" {{ $paciente->genero == 'femenino' ? 'checked' : '' }} required> Femenino</label>
                    <label><input type="radio" name="genero" value="masculino" {{ $paciente->genero == 'masculino' ? 'checked' : '' }} required> Masculino</label>
                    <label><input type="radio" name="genero" value="otro" {{ $paciente->genero == 'otro' ? 'checked' : '' }} required> Otro</label>
                </div>
            </div>

            <!-- Fecha de nacimiento -->
            <div>
                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ $paciente->fecha_nacimiento }}" required>
            </div>
            
            <!-- Altura -->
            <div>
                <label for="altura">Altura (en centímetros)</label>
                <input type="number" id="altura" name="altura" value="{{ $paciente->altura }}" required />
            </div>

            <!-- Peso -->
            <div>
                <label for="peso">Peso (en kilogramos)</label>
                <input type="number" step="0.01" id="peso" name="peso" value="{{ $paciente->peso }}" required />
            </div>

            <!-- Tipo sangre -->
            <div>
                <label for="sangre">Tipo de sangre</label>
                <select id="sangre" name="sangre">
                    <option value="O+" {{ $paciente->sangre == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ $paciente->sangre == 'O-' ? 'selected' : '' }}>O-</option>
                    <option value="A+" {{ $paciente->sangre == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ $paciente->sangre == 'A-' ? 'selected' : '' }}>A-</option>
                </select>
            </div>

            <!-- Alergias -->
            <div>
                <label for="alergias">Alergias</label>
                <textarea id="alergias" name="alergias">{{ $paciente->alergias }}</textarea>
            </div>

            <button type="submit">Actualizar</button>
        </form>
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
