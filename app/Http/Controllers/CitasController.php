<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\Doctores;
use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CitasController extends Controller
{
    public function index()
    {
        $citas = Citas::with(['paciente', 'doctor'])->get();
        return view('citas.citas', compact('citas'));
    }

    public function crear()
    {
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
        return view('citas.crear', compact('pacientes', 'doctores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|string',
        ]);

        // Verificar disponibilidad del doctor
        $doctor = Doctores::findOrFail($request->doctor_id);
        $disponible = $doctor->diasTrabajo()->where('dia', date('l', strtotime($request->fecha)))->exists();

        if (!$disponible) {
            return back()->withErrors(['El doctor no está disponible ese día']);
        }

        $horaOcupada = Citas::where('doctor_id', $request->doctor_id)
                            ->where('fecha', $request->fecha)
                            ->where('hora', $request->hora)
                            ->exists();

        if ($horaOcupada) {
            return back()->withErrors(['El doctor ya tiene una cita programada a esa hora']);
        }

        Citas::create($request->all());
        return redirect()->route('citas.index')->with('success', 'Cita agendada exitosamente.');
    }

    public function editar($id)
    {
        $cita = Citas::findOrFail($id);
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
        return view('citas.editar', compact('cita', 'pacientes', 'doctores'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|string',
        ]);

        $cita = Citas::findOrFail($id);

        $doctor = Doctores::findOrFail($request->doctor_id);
        $disponible = $doctor->diasTrabajo()->where('dia', date('l', strtotime($request->fecha)))->exists();

        if (!$disponible) {
            return back()->withErrors(['El doctor no está disponible ese día']);
        }

        $horaOcupada = Citas::where('doctor_id', $request->doctor_id)
                            ->where('fecha', $request->fecha)
                            ->where('hora', $request->hora)
                            ->where('id', '!=', $id)
                            ->exists();

        if ($horaOcupada) {
            return back()->withErrors(['El doctor ya tiene una cita programada a esa hora']);
        }

        $cita->update($request->all());
        return redirect()->route('citas.index')->with('success', 'Cita actualizada exitosamente.');
    }

    public function eliminar($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada exitosamente.');
    }
}