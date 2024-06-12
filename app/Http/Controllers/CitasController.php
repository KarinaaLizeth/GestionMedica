<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\Doctores;
use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CitasController extends Controller
{
    public function index(): View
    {
        $citas = Citas::with(['paciente', 'doctor'])->get();
        return view('citas.citas', ['citas' => $citas]);
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
            'hora' => 'required|date_format:H:i',
            'estado' => 'required|in:Completada,Cancelada,En proceso',
        ]);

        Citas::create($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente.');
    }
}
