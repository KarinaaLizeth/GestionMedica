@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/historial.css') }}">
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="stats mb-4">
                <div class="stat-card">
                    <h3>Citas</h3>
                    <p>{{ $citas->count() }}</p>
                </div>
                <div class="stat-card">
                    <h3>Consultas</h3>
                    <p>{{ $consultas->count() }}</p>
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
                <!-- Lista de Citas -->
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
                                    @forelse($citas as $cita)
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
                                    @empty
                                        <tr>
                                            <td colspan="4">No hay citas disponibles.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Lista de Consultas -->
                <div class="tab-pane fade" id="consultations" role="tabpanel" aria-labelledby="consultations-tab">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2>Lista de Consultas</h2>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Doctor</th>
                                        <th>Motivo</th>
                                        <th>Notas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($consultas as $consulta)
                                        <tr>
                                            <td>{{ $consulta->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}</td>
                                            <td>{{ $consulta->motivo_consulta }}</td>
                                            <td>{{ $consulta->notas_padecimiento }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No hay consultas disponibles.</td>
                                        </tr>
                                    @endforelse
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
