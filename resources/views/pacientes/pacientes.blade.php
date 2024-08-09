@extends('layouts.app')

@section('content')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900 p-4">
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

    <div class="flex items-center justify-between flex-wrap md:flex-nowrap space-y-4 md:space-y-0 mb-4">
        <div class="flex items-center space-x-4">
            <label for="table-search" class="sr-only">Buscar</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar paciente">
            </div>
        </div>
        <div class="flex items-center">
            <a href="{{ route('pacientes.crear') }}" class="text-white focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="background-color: #247b7b; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#83c5be'" onmouseout="this.style.backgroundColor='#247b7b'">
            <ion-icon name="add-circle-outline" style="font-size: 1.3em; vertical-align: middle;" class="mr-1"></ion-icon>
            Agregar Paciente
            </a>
        </div>
    </div>
    <table id="pacientesTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase" style="background-color: #daffef;">
            <tr>
                <th scope="col" class="px-6 py-3">Nombres</th>
                <th scope="col" class="px-6 py-3">Apellidos</th>
                <th scope="col" class="px-6 py-3">Género</th>
                <th scope="col" class="px-6 py-3">Teléfono</th>
                <th scope="col" class="px-6 py-3">Teléfono Emergencia</th>
                <th scope="col" class="px-6 py-3">Fecha Nacimiento</th>
                <th scope="col" class="px-6 py-3">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $paciente)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">{{ $paciente->nombres }}</td>
                <td class="px-6 py-4">{{ $paciente->apellidos }}</td>
                <td class="px-6 py-4">{{ $paciente->genero }}</td>
                <td class="px-6 py-4">{{ $paciente->telefono }}</td>
                <td class="px-6 py-4">{{ $paciente->telefono_emergencia }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('Y-m-d') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('pacientes.editar', $paciente->id) }}" class="text-blue-600 dark:text-blue-500 hover:underline"><ion-icon name="create-outline"></ion-icon> Editar</a>
                    @if(Auth::user()->role->nombre === 'Admin' || Auth::user()->role->nombre === 'Doctor')
                        <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" class="d-inline-block form-eliminar">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-red-600 dark:text-red-500 hover:underline btn-eliminar"><ion-icon name="trash-outline"></ion-icon> Eliminar</button>
                        </form>
                    @endif
                    <a href="{{ route('consultas.crear.paciente', $paciente->id) }}" class="text-blue-600 dark:text-blue-500 hover:underline"><ion-icon name="open-outline"></ion-icon> Consultar</a><br>
                    <a href="{{ route('pacientes.historial', $paciente->id) }}" class="text-blue-600 dark:text-blue-500 hover:underline"><ion-icon name="file-tray-full-outline"></ion-icon> Ver Paciente</a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Interceptar el clic en los botones de eliminar
    document.querySelectorAll('.btn-eliminar').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var form = this.closest('form');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Inicializar DataTables
    var table = $('#pacientesTable').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copy',
            exportOptions: {
                columns: ':not(:last-child)' // Excluir la última columna (Acción)
            }
        },
        {
            extend: 'csv',
            exportOptions: {
                columns: ':not(:last-child)', // Excluir la última columna (Acción)
                charset: 'utf-8',
                bom: true
            }
        },
        {
            extend: 'excel',
            exportOptions: {
                columns: ':not(:last-child)' // Excluir la última columna (Acción)
            }
        },
        {
            extend: 'pdf',
            exportOptions: {
                columns: ':not(:last-child)' // Excluir la última columna (Acción)
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: ':not(:last-child)' // Excluir la última columna (Acción)
            }
        }
    ],
    language: {
        url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
    }
});


    // Configurar búsqueda personalizada
    $('#table-search-users').on('keyup', function() {
        table.search(this.value).draw();
    });
});

</script>
@endsection
