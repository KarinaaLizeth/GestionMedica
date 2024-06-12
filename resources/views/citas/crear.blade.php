@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
  <div class="container max-w-screen-lg mx-auto">
    <div>
      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <form action="{{ route('citas.store') }}" method="POST">
          @csrf
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
            <div class="text-gray-600">
              <p class="font-medium text-lg">Agendar Cita</p>
              <p>Ingrese todos los campos</p>
            </div>

            <div class="lg:col-span-2">
              <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                <div class="md:col-span-5">
                  <label for="paciente_id">Paciente</label>
                  <select name="paciente_id" id="paciente_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                    @foreach($pacientes as $paciente)
                      <option value="{{ $paciente->id }}">{{ $paciente->nombres }} {{ $paciente->apellidos }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="md:col-span-5">
                  <label for="doctor_id">Doctor</label>
                  <select name="doctor_id" id="doctor_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                    @foreach($doctores as $doctor)
                      <option value="{{ $doctor->id }}">{{ $doctor->nombres }} {{ $doctor->apellidos }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="md:col-span-3">
                  <label for="fecha">Fecha</label>
                  <input type="date" name="fecha" id="fecha" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required />
                </div>

                <div class="md:col-span-2">
                  <label for="hora">Hora</label>
                  <input type="time" name="hora" id="hora" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required />
                </div>

                <div class="md:col-span-5">
                  <label for="estado">Estado</label>
                  <select name="estado" id="estado" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                    <option value="Completada">En proceso</option>
                    <option value="Cancelada">Cancelada</option>
                    <option value="En proceso">Completada</option>
                  </select>
                </div>

                <div class="md:col-span-5 text-right">
                  <div class="inline-flex items-end">
                    <button class="text-black font-bold py-2 px-4 rounded" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'"  onmouseout="this.style.backgroundColor='#daffef'">Agendar</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
