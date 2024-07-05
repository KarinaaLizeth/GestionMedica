<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PacientesController extends Controller
{
    //mostrar la vista principal con la lista de pacientes
    public function index()
    {
        // Obtener todos los pacientes de la bd
        $pacientes = Pacientes::all();
        return view('pacientes.pacientes', ['pacientes' => $pacientes]);
    }

    //mostrar el formulario de creación de pacientes
    public function crear()
    {
        return view('pacientes.crear');
    }

    //almacenar un nuevo paciente en la bd
    public function store(Request $request)
    {
        // validar los datos del formulario
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

        //crear un nuevo registro de paciente con los datos validados
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

    //mostrar el formulario de edición de un paciente existente
    public function editar($id)
    {
        // Buscar el paciente por su ID 
        $paciente = Pacientes::findOrFail($id);
        return view('pacientes.editar', compact('paciente'));
    }

    //actualizar los datos de un paciente en la bd
    public function actualizar(Request $request, $id)
    {
        // validar los datos del formulario
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

        // buscar el paciente por su ID 
        $paciente = Pacientes::findOrFail($id);
        // formatear la fecha para que se pueda mostrar en la vista de edición
        $paciente->fecha_nacimiento = $paciente->fecha_nacimiento->format('Y-m-d');
        $paciente->update($request->all());

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado.');
    }

    //eliminar un paciente de la bd
    public function eliminar($id)
    {
        //buscar el paciente por su ID 
        $paciente = Pacientes::findOrFail($id);
        //eliminar el paciente
        $paciente->delete();

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado.');
    }
}
