<?php

namespace App\Http\Controllers;


use App\Models\Doctores;
use App\Models\DiaTrabajo;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 

class DoctoresController extends Controller
{
    public function index()
    {
        $doctores = Doctores::with(['diasTrabajo', 'horarios'])->get();
        return view('doctores.doctores', compact('doctores'));
    }

    public function crear()
    {
        return view('doctores.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:doctores',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'required|numeric',
            'especialidad' => 'required|string|max:255',
            'precio_consulta' => 'required|numeric',
            'duracion_cita' => 'required|integer|min:10|max:60',
            'dias_disponibles' => 'required|array',
            'available_time_from' => 'required|array',
            'available_time_to' => 'required|array',
        ]);

        $doctor = Doctores::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
            'precio_consulta' => $request->precio_consulta,
            'duracion_cita' => $request->duracion_cita,
        ]);

        foreach ($request->dias_disponibles as $dia) {
            DiaTrabajo::create([
                'doctor_id' => $doctor->id,
                'dia' => $dia,
            ]);
        }

        for ($i = 0; $i < count($request->available_time_from); $i++) {
            Horario::create([
                'doctor_id' => $doctor->id,
                'hora_inicio' => $request->available_time_from[$i],
                'hora_fin' => $request->available_time_to[$i],
            ]);
        }

        return redirect()->route('doctores.index')->with('success', 'Doctor registrado exitosamente');
    }

    public function editar($id)
    {
        $doctor = Doctores::with(['diasTrabajo', 'horarios'])->findOrFail($id);
        return view('doctores.editar', compact('doctor'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:doctores,correo,'.$id,
            'telefono' => 'required|numeric',
            'especialidad' => 'required|string|max:255',
            'precio_consulta' => 'required|numeric',
            'duracion_cita' => 'required|integer|min:10|max:60',
            'dias_disponibles' => 'required|array',
            'available_time_from' => 'required|array',
            'available_time_to' => 'required|array',
        ]);

        $doctor = Doctores::findOrFail($id);
        $doctor->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
            'precio_consulta' => $request->precio_consulta,
            'duracion_cita' => $request->duracion_cita,
        ]);

        DiaTrabajo::where('doctor_id', $doctor->id)->delete();
        foreach ($request->dias_disponibles as $dia) {
            DiaTrabajo::create([
                'doctor_id' => $doctor->id,
                'dia' => $dia,
            ]);
        }

        Horario::where('doctor_id', $doctor->id)->delete();
        for ($i = 0; $i < count($request->available_time_from); $i++) {
            Horario::create([
                'doctor_id' => $doctor->id,
                'hora_inicio' => $request->available_time_from[$i],
                'hora_fin' => $request->available_time_to[$i],
            ]);
        }

        return redirect()->route('doctores.index')->with('success', 'Doctor actualizado exitosamente');
    }

    public function eliminar($id)
    {
        $doctor = Doctores::findOrFail($id);
        $doctor->delete();
        return redirect()->route('doctores.index')->with('success', 'Doctor eliminado exitosamente');
    }
}
