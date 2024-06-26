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
    //Mostrar vista register cuando se de clic en crear 
    public function index(): View
    {
        $pacientes = Pacientes::all();
        return view('pacientes.pacientes', ['pacientes' => $pacientes]);
    }

    // Método para mostrar el formulario de edición
    public function edit($id): View
    {
        $paciente = Pacientes::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }
    

    // formulario de crear paciente
    public function create(): View
    {
        return view('pacientes.create');
    }

     public function store(Request $request): RedirectResponse
     {
         $request->validate([
             'nombres' => ['required', 'string', 'max:255'],
             'apellidos' => ['required', 'string', 'max:255'],
             'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pacientes'],
             'password' => ['required', 'confirmed', Rules\Password::defaults()],
             'telefono' => ['required', 'int'],
             'direccion' => ['required', 'string', 'max:255'],
             'edad' => ['required', 'int'],
         ]);
     
         $paciente = Pacientes::create([
             'nombres' => $request->nombres,
             'apellidos' => $request->apellidos,
             'correo' => $request->correo,
             'password' => Hash::make($request->password),
             'telefono' => $request->telefono,
             'direccion' => $request->direccion,
             'edad' => $request->edad,
         ]);
     
         return redirect()->route('pacientes.index')->with('success', 'Nuevo paciente agregado.');
     }
     
     
    // Método para actualizar el paciente
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pacientes,correo,'.$id],
            'telefono' => ['required', 'int'],
            'direccion' => ['required', 'string', 'max:255'],
            'edad' => ['required', 'int'],
        ]);

        $paciente = Pacientes::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado.');
    }
}
