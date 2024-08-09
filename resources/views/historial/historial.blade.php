@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/historial.css') }}">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="header-card">
                <div class="info">Información del Paciente</div>
                <div class="image-container">
                    <img src="{{ asset('images/paciente.png') }}" alt="Patient Information">
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <div class="avatar rounded-full h-16 w-16 flex items-center justify-center text-white text-3xl mx-auto">
                        {{ substr($paciente->nombres, 0, 1) }}{{ substr($paciente->apellidos, 0, 1) }}
                    </div>
                    <h1 class="mt-5">{{ $paciente->nombres }} {{ $paciente->apellidos }}</h1>
                    <p>{{ $paciente->correo }}</p>
                    <a href="{{ route('pacientes.editar', $paciente->id) }}" class="btn btn-primary mt-2">Editar</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2>Información Personal</h2>
                </div>
                <div class="card-body">
                    <p><strong>Telefono:</strong> {{ $paciente->telefono }}</p>
                    <p><strong>Correo:</strong> {{ $paciente->correo }}</p>
                    <p><strong>Edad:</strong> {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }}</p>
                    <p><strong>Genero:</strong> {{ $paciente->genero }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="stats mb-4">
                <div class="stat-card">
                    <h3>Citas</h3>
                    <p>{{ $numCitas }}</p>
                </div>
                <div class="stat-card">
                    <h3>Consultas</h3>
                    <p>{{ $numConsultas }}</p>
                </div>
            </div>
            <!-- Pestañas para alternar entre citas y consultas -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="appointments-tab" data-toggle="tab" href="#appointments" role="tab" aria-controls="appointments" aria-selected="true">Citas</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="consultations-tab" data-toggle="tab" href="#consultations" role="tab" aria-controls="consultations" aria-selected="false">Consultas</a>
                </li>
                
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2>Lista de Citas</h2>
                        </div>
                        
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Doctor</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($citas as $cita)
                                        <tr>
                                            <td>{{ $cita->fecha }}</td>
                                            <td>{{ $cita->hora }}</td>
                                            <td>{{ $cita->doctor->nombres }} {{ $cita->doctor->apellidos }}</td>
                                            <td>
                                                @if($cita->estado == 'completada')
                                                    <span class="badge bg-success">Completada</span>
                                                @elseif($cita->estado == 'cancelada')
                                                    <span class="badge bg-danger">Cancelada</span>
                                                @else
                                                    <span class="badge bg-warning">{{ ucfirst($cita->estado) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="consultations" role="tabpanel" aria-labelledby="consultations-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2>Lista de Consultas</h2>
                            <a href="{{ route('consultas.porPaciente', $paciente->id) }}" class="btn btn-primary mt-2">Ver todas las consultas</a>

                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Doctor</th>
                                        <th>Motivo</th>
                                        <th>Notas</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($consultas as $consulta)
                                        <tr>
                                            <td>{{ $consulta->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}</td>
                                            <td>{{ $consulta->motivo_consulta }}</td>
                                            <td>{{ $consulta->notas_padecimiento }}</td>
                                            <td>
                                                <a href="{{ route('consultas.ver', $consulta->id) }}" class="btn btn-info btn-sm">Ver</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection