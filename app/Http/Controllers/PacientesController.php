<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 


class PacientesController extends Controller
{
    public function index()
    {
        $pacientes = Pacientes::all();
        return view('pacientes.pacientes', ['pacientes' => $pacientes]);
    }

    public function crear()
    {
        return view('pacientes.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:pacientes'],
            'telefono' => ['required', 'integer'],
            'telefono_emergencia' => ['required', 'integer'],
            'genero' => ['required', 'string'],
            'fecha_nacimiento' => ['required', 'date'],
            'altura' => ['required', 'integer'],
            'peso' => ['required', 'numeric'],
            'sangre' => ['required', 'string'],
            'alergias' => ['nullable', 'string'],
        ]);

        Pacientes::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'telefono_emergencia' => $request->telefono_emergencia,
            'genero' => $request->genero,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'altura' => $request->altura,
            'peso' => $request->peso,
            'sangre' => $request->sangre,
            'alergias' => $request->alergias,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Nuevo paciente agregado.');
    }

    public function editar($id)
    {
        $paciente = Pacientes::findOrFail($id);
        return view('pacientes.editar', compact('paciente'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:pacientes,correo,'.$id],
            'telefono' => ['required', 'integer'],
            'telefono_emergencia' => ['required', 'integer'],
            'genero' => ['required', 'string'],
            'fecha_nacimiento' => ['required', 'date'],
            'altura' => ['required', 'integer'],
            'peso' => ['required', 'numeric'],
            'sangre' => ['required', 'string'],
            'alergias' => ['nullable', 'string'],
        ]);

        $paciente = Pacientes::findOrFail($id);
        $paciente->fecha_nacimiento = $paciente->fecha_nacimiento->format('Y-m-d'); // Formatear la fecha para que se pueda mostrar en la vista ediatr 
        $paciente->update($request->all());

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado.');
    }

    public function eliminar($id)
    {
        $paciente = Pacientes::findOrFail($id);
        $paciente->delete();

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado.');
    }
}