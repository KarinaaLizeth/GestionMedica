@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Citas</title>
    <link href="{{ asset('css/listacitas.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="calendar-header" style="display: flex; justify-content: flex-start; margin-bottom: 20px;">
            <a href="{{ route('citas.crear') }}" class="btn btn-primary" style="margin-right: 10px;">
                <ion-icon name="add-circle-outline"></ion-icon> Agregar Cita
            </a>     
            <a href="{{ route('citas.index') }}" class="btn btn-primary" style="margin-right: 10px;">
                <ion-icon name="list-outline"></ion-icon> Ver agenda de citas
            </a>
        </div>
        <ul class="tab-list">
            <li class="tab-item {{ $filtro == 'hoy' ? 'active' : '' }}"><a href="{{ route('citas.lista', ['filtro' => 'hoy']) }}">Hoy</a></li>
            <li class="tab-item {{ $filtro == 'en_proceso' ? 'active' : '' }}"><a href="{{ route('citas.lista', ['filtro' => 'en_proceso']) }}">En Proceso</a></li>
            <li class="tab-item {{ $filtro == 'completadas' ? 'active' : '' }}"><a href="{{ route('citas.lista', ['filtro' => 'completadas']) }}">Completadas</a></li>
            <li class="tab-item {{ $filtro == 'canceladas' ? 'active' : '' }}"><a href="{{ route('citas.lista', ['filtro' => 'canceladas']) }}">Canceladas</a></li>
        </ul>
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Doctor</th>
                    <th>Paciente</th>
                    <th>Telefono del Paciente</th>
                    <th>Correo del Paciente</th>
                    <th>Día</th>
                    <th>Hora</th>
                    @if ($filtro == 'en_proceso')
                        <th>Acción</th>
                    @else
                        <th>Estado</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $cita)
                    <tr>
                        <td>{{ $cita->id }}</td>
                        <td>{{ $cita->doctor->nombres }}</td>
                        <td>{{ $cita->paciente->nombres }}</td>
                        <td>{{ $cita->paciente->telefono }}</td>
                        <td>{{ $cita->paciente->correo }}</td>
                        <td>{{ $cita->fecha }}</td>
                        <td>{{ $cita->hora }}</td>
                        @if ($filtro == 'en_proceso')
                            <td>
                                <a href="{{ route('citas.cambiarEstado', ['id' => $cita->id, 'estado' => 'completada']) }}" class="btn btn-success" style="margin-right: 10px;">
                                    Completar
                                </a>
                                <a href="{{ route('citas.cambiarEstado', ['id' => $cita->id, 'estado' => 'cancelada']) }}" class="btn btn-danger" style="margin-right: 10px;">
                                    Cancelar
                                </a>
                                <a href="{{ route('citas.editar', ['id' => $cita->id, 'estado' => 'en proceso']) }}" class="btn btn-editar" style="margin-right: 10px;">
                                    Editar
                                </a>
                                <a href="{{ route('consultas.crear', ['cita_id' => $cita->id]) }}" class="btn btn-consulta" >
                                    Ir a consulta
                                </a>
                            </td>
                        @else
                            <td>{{ $cita->estado }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $citas->links() }}
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
@endsection
