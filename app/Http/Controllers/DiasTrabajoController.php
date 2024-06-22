<?php

namespace App\Http\Controllers;

use App\Models\DiaTrabajo;
use Illuminate\Http\Request;

class DiasTrabajoController extends Controller
{
    public function index()
    {
        $diasTrabajo = DiaTrabajo::with('doctor')->get();
        return view('dias_trabajo.index', compact('diasTrabajo'));
    }

    public function create()
    {
        return view('dias_trabajo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctores,id',
            'dia' => 'required|string|max:255',
        ]);

        DiaTrabajo::create($request->all());

        return redirect()->route('dias_trabajo.index')->with('success', 'Día de trabajo registrado exitosamente');
    }

    public function edit($id)
    {
        $diaTrabajo = DiaTrabajo::findOrFail($id);
        return view('dias_trabajo.edit', compact('diaTrabajo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctores,id',
            'dia' => 'required|string|max:255',
        ]);

        $diaTrabajo = DiaTrabajo::findOrFail($id);
        $diaTrabajo->update($request->all());

        return redirect()->route('dias_trabajo.index')->with('success', 'Día de trabajo actualizado exitosamente');
    }

    public function destroy($id)
    {
        $diaTrabajo = DiaTrabajo::findOrFail($id);
        $diaTrabajo->delete();

        return redirect()->route('dias_trabajo.index')->with('success', 'Día de trabajo eliminado exitosamente');
    }
}
