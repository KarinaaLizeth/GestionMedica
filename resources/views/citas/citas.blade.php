@extends('layouts.app')
@vite(['resources/js/pages/citas.js'])
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset='utf-8' />
    <script src="{{ asset('assets/fullcalendar/dist/index.global.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/citas.css') }}">
</head>

<body>
    <div class="calendar-header">
        <a href="{{ route('citas.crear') }}" class="btn btn-primary"><ion-icon name="add-circle-outline"></ion-icon>Agregar Cita</a>
        <a href="{{ route('citas.lista') }}" class="btn btn-primary" style="margin-left: 10px;"><ion-icon name="list-outline"></ion-icon>Ver lista de citas</a>
    </div>
    <div class="content-wrapper">
        <div id="calendar-wrap">
            <div id="calendar"></div>
        </div>
        <div class="appointment-list">
            <h3>Lista de Citas | <span id="selected-date">{{ \Carbon\Carbon::today()->toDateString() }}</span></h3>
            <table id="appointment-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Doctor</th>
                        <th>Paciente</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="appointment-list-body">
                    <!-- Citas se llenarán dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para mostrar citas -->
    <div id="citas-modal" class="modal">
        <div class="modal-content">
        <span class="close"><ion-icon name="close-circle-outline"></ion-icon></span>
            <h3>Citas del día <span id="modal-date"></span></h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Doctor</th>
                        <th>Paciente</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="modal-appointment-list-body">
                    @foreach ($citas as $cita)
                        <tr>
                            <td>{{ $cita->id }}</td>
                            <td>{{ $cita->doctor->nombres }} {{ $cita->doctor->apellidos }}</td>
                            <td>{{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}</td>
                            <td>{{ $cita->hora }}</td>
                            <td>{{ $cita->estado }}</td>
                            <td>
                                @if ($cita->estado == 'En proceso')
                                    <a href="{{ route('citas.cambiarEstado', ['id' => $cita->id, 'estado' => 'completada']) }}" class="btn btn-success">Completar</a>
                                    <a href="{{ route('citas.cambiarEstado', ['id' => $cita->id, 'estado' => 'cancelada']) }}" class="btn btn-danger">Cancelar</a>
                                    <a href="{{ route('citas.editar', ['id' => $cita->id]) }}" class="btn btn-editar">Editar</a>
                                    <a href="{{ route('consultas.crear', ['cita_id' => $cita->id]) }}" class="btn btn-consulta">Ir a consulta</a>
                                @else
                                    <span class="badge badge-{{ $cita->estado == 'completada' ? 'success' : 'danger' }}">{{ $cita->estado }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

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
