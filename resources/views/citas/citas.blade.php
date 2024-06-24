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
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Paciente</th>
                        <th>Doctor</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($citas as $cita)
                        <tr>
                            <td>{{ $cita->id }}</td>
                            <td>{{ $cita->doctor->nombres }}</td>
                            <td>{{ $cita->paciente->nombres }}</td>
                            <td>{{ $cita->hora }}</td>
                            <td>{{ $cita->estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</body>
</html>
@endsection
