<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Consultas;
use App\Models\Pacientes;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function mostrarHistorial($paciente_id)
    {
        // Obtener el paciente
        $paciente = Pacientes::findOrFail($paciente_id);

        // Obtener todas las citas del paciente
        $citas = Citas::where('paciente_id', $paciente_id)->get();

        // Obtener todas las consultas del paciente
        $consultas = Consultas::where('paciente_id', $paciente_id)->get();
       
        // Contar el número de citas y consultas
        $numCitas = $citas->count();
        $numConsultas = $consultas->count();

        return view('historial.historial', compact('paciente', 'citas', 'consultas', 'numCitas', 'numConsultas'));
    }
}