<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicoColaborador;
use App\Models\User;
use App\Models\Consultas;
use App\Models\Role;
use App\Models\ConsultasCompartidas;
use Illuminate\Support\Facades\Hash;

class MedicoColaboradorController extends Controller
{

    public function index()
    {
        $colaboradores = MedicoColaborador::all();
        return view('medico_colaborador.medicos', compact('colaboradores'));
    }
    
    public function crear()
    {
        $colaboradores = MedicoColaborador::all();
        return view('medico_colaborador.crear', compact('colaboradores'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:medico_colaboradores',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'required|numeric',
        ]);
        $medicoColaborador = MedicoColaborador::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
        ]);

        $role = Role::whereRaw('LOWER(nombre) = ?', ['MedicoColaborador'])->first();
        if ($role) {
            User::create([
                'name' => $medicoColaborador->nombres . ' ' . $medicoColaborador->apellidos,
                'email' => $medicoColaborador->correo,
                'password' => Hash::make($request->password),
                'role_id' => $role->id,
            ]);
        } else {
            return redirect()->route('colaboradores.index')->with('error', 'Error: El rol de médico colaborador no existe.');
        }

        return redirect()->route('colaboradores.index')->with('success', 'Médico colaborador registrado exitosamente');
    }


    
    
}
