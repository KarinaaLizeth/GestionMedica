@extends('layouts.app')

@section('content')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900 p-4">
    <h2>Solicitudes de Consulta</h2>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase" style="background-color: #daffef;">
            <tr>
                <th scope="col" class="px-6 py-3">Doctor Solicitante</th>
                <th scope="col" class="px-6 py-3">Paciente</th>
                <th scope="col" class="px-6 py-3">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($solicitudes as $solicitud)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">{{ $solicitud->solicitante->nombres }}</td>
                <td class="px-6 py-4">{{ $solicitud->user->nombres }}</td>
                <td class="px-6 py-4">
                    <form action="{{ route('consultas.aprobar', $solicitud->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success" style="background-color: #34c38f; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Aprobar</button>
                    </form>
                    <form action="{{ route('consultas.rechazar', $solicitud->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="background-color: #cf5a5a; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Rechazar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

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

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif
@endsection
