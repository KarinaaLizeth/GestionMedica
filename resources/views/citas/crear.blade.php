@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/crear.css') }}">

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
                <select name="paciente_id" id="paciente_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                    @foreach($pacientes as $paciente)
                      <option value="{{ $paciente->id }}">{{ $paciente->nombres }} {{ $paciente->apellidos }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Doctor -->
            <div>
                <label for="doctor_id">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                    @foreach($doctores as $doctor)
                      <option value="{{ $doctor->id }}">{{ $doctor->nombres }} {{ $doctor->apellidos }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha -->
            <div>
              <label for="fecha">Fecha</label>
              <input type="date" name="fecha" id="fecha" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required />
            </div>

            <!-- Hora -->
            <div>
              <label for="hora">Hora</label>
              <input type="time" name="hora" id="hora" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required />
            </div>

            <!-- Estado -->
            <div>
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                    <option value="En proceso">En proceso</option>
                    <option value="Completada">Completada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>

            <button type="submit">Registrar</button>
        </form>
    </div>
</div>
<br><br>
@endsection
