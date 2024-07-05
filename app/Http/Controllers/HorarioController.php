<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // mostrar todos los horarios junto con la información del doctor asociado
    public function index()
    {
        $horarios = Horario::with('doctor')->get();
        return view('horarios.index', compact('horarios'));
    }

    // mostrar el formulario para crear un nuevo horario
    public function create()
    {
        return view('horarios.create');
    }

    // guardar un nuevo horario en la bd
    public function store(Request $request)
    {
        // validar los datos del formulario
        $request->validate([
            'doctor_id' => 'required|exists:doctores,id', // asegurar que el doctor existe en la bd
            'hora_inicio' => 'required|date_format:H:i', // validar formato de hora de inicio
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio', // validar formato de hora de fin y que sea después de la hora de inicio
        ]);

        // crear un nuevo horario con los datos validados
        Horario::create($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario registrado exitosamente');
    }

    // mostrar el formulario para editar un horario
    public function edit($id)
    {
        $horario = Horario::findOrFail($id); // buscar el horario por ID o lanzar un error si no se encuentra
        return view('horarios.edit', compact('horario')); // mostrar la vista de edición con los datos del horario
    }

    // actualizar los datos de un horario en la bd
    public function update(Request $request, $id)
    {

        $request->validate([
            'doctor_id' => 'required|exists:doctores,id', // asegurar que el doctor existe en la bd
            'hora_inicio' => 'required|date_format:H:i', // validar formato de hora de inicio
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio', // validar formato de hora de fin y que sea después de la hora de inicio
        ]);

        // encontrar el horario por ID o lanzar un error si no se encuentra
        $horario = Horario::findOrFail($id);
        // actualizar el horario con los datos validados
        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente');
    }

    // eliminar un horario de la bd
    public function destroy($id)
    {
        // buscar el horario por ID o lanzar un error si no se encuentra
        $horario = Horario::findOrFail($id);
        // eliminar el horario
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado exitosamente');
    }
}
