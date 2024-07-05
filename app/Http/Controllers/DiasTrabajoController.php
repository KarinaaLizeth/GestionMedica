<?php

namespace App\Http\Controllers;

use App\Models\DiaTrabajo;
use Illuminate\Http\Request;

class DiasTrabajoController extends Controller
{
    // método para obtener y mostrar todos los días de trabajo
    public function index()
    {
        $diasTrabajo = DiaTrabajo::with('doctor')->get(); // obtener todos los días de trabajo con la relación de doctores
        return view('dias_trabajo.index', compact('diasTrabajo')); 
    }

    //mostrar el formulario de creación de un nuevo día de trabajo
    public function create()
    {
        return view('dias_trabajo.create'); 
    }

    // almacenar un nuevo día de trabajo 
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctores,id',
            'dia' => 'required|string|max:255',
        ]);

        DiaTrabajo::create($request->all()); 

        return redirect()->route('dias_trabajo.index')->with('success', 'Día de trabajo registrado exitosamente');
    }

    // mostrar el formulario de editar
    public function edit($id)
    {
        $diaTrabajo = DiaTrabajo::findOrFail($id); 
        return view('dias_trabajo.edit', compact('diaTrabajo')); 
    }

    // actualizar un día de trabajo 
    public function update(Request $request, $id)
    {
        // validar los datos del formulario
        $request->validate([
            'doctor_id' => 'required|exists:doctores,id',
            'dia' => 'required|string|max:255',
        ]);

        $diaTrabajo = DiaTrabajo::findOrFail($id); // encontrar el día de trabajo por su ID
        $diaTrabajo->update($request->all()); 

        return redirect()->route('dias_trabajo.index')->with('success', 'Día de trabajo actualizado exitosamente');
    }

    // método para eliminar un día de trabajo  de la bd
    public function destroy($id)
    {
        $diaTrabajo = DiaTrabajo::findOrFail($id); // encontrar el día de trabajo por su ID
        $diaTrabajo->delete(); // eliminar el día de trabajo


        return redirect()->route('dias_trabajo.index')->with('success', 'Día de trabajo eliminado exitosamente');
    }
}
