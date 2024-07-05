<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Models\Consultas;
use App\Models\SignosVitales;
use App\Models\Receta;
use App\Models\ServiciosConsulta;
use App\Models\Servicios;
use App\Models\Citas;
use App\Models\Doctores;
use App\Models\Pacientes;

class ConsultasController extends Controller
{
    //obtener las consultas con las relaciones de pacientes y doctores
    public function index(): View
    {
        $consultas = Consultas::with(['paciente', 'doctor'])->get();
        return view('consultas.consultas', compact('consultas'));
    }

    //obtener las consultas con las relaciones de pacientes y doctores
    public function listaConsultas(): View
    {
        $consultas = Consultas::with(['paciente', 'doctor'])->get();
        return view('consultas.consultas', compact('consultas'));
    }

    //mostrar el formulario de creación de una consulta cuando se inicia desde la vista de un paciente específico
    public function crearDesdePaciente(Pacientes $paciente): View
    {
        $servicios = Servicios::all();
        $doctores = Doctores::all();
        return view('consultas.crear', compact('servicios', 'paciente', 'doctores'));
    }

    //crear consulta
    public function crear(Request $request): View
    {
        $servicios = Servicios::all();
        $paciente = null;
        $doctor = null;
        $fecha = null;
        $hora = null;
        $doctores = Doctores::all(); 

        if ($request->has('cita_id'))  { //saber si hay un ID de la cita
            $cita = Citas::find($request->input('cita_id'));
            $paciente = $cita->paciente;
            $doctor = $cita->doctor;
            $fecha = $cita->fecha;
            $hora = $cita->hora;
        }

        return view('consultas.crear', compact('servicios', 'paciente', 'doctor', 'fecha', 'hora'));
    }

    //validar y guardar nueva consulta
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'motivo_consulta' => 'required|string',
            'notas_padecimiento' => 'nullable|string',
            'temperatura' => 'required|numeric',
            'talla' => 'required|integer',
            'frecuencia_cardiaca' => 'required|integer',
            'saturacion_oxigeno' => 'required|integer',
            'medicacion' => 'required|array',
            'cantidad_medicamento' => 'required|array',
            'frecuencia_medicamento' => 'required|array',
            'duracion_medicamento' => 'required|array',
            'notas_receta' => 'nullable|string',
            'servicio' => 'required|array',
            'cantidad_servicio' => 'required|array',
            'precio' => 'required|array',
            'notas_servicio' => 'nullable|string'
        ]);

        
        // Debug data received
        //logger($request->all());
       // dd($request->validated());

        // crear la consulta
        $consulta = Consultas::create([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'motivo_consulta' => $request->motivo_consulta,
            'notas_padecimiento' => $request->notas_padecimiento,
        ]);
    
        //dd($consulta);

        // crear los signos vitales
        SignosVitales::create([
            'consulta_id' => $consulta->id,
            'temperatura' => $request->temperatura,
            'talla' => $request->talla,
            'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
            'saturacion_oxigeno' => $request->saturacion_oxigeno,
        ]);
    
        // crear las recetas
        foreach ($request->medicacion as $index => $medicacion) {
            Receta::create([
                'consulta_id' => $consulta->id,
                'medicacion' => $medicacion,
                'cantidad_medicamento' => $request->cantidad_medicamento[$index],
                'frecuencia_medicamento' => $request->frecuencia_medicamento[$index],
                'duracion_medicamento' => $request->duracion_medicamento[$index],
                'notas_receta' => $request->notas_receta, 
            ]);
        }
    
        // crear los servicios de consulta
        foreach ($request->servicio as $index => $servicio) {
            ServiciosConsulta::create([
                'consulta_id' => $consulta->id,
                'servicio_id' => $servicio,
                'cantidad_servicio' => $request->cantidad_servicio[$index],
                'precio' => $request->precio[$index],
                'notas_servicio' => $request->notas_servicio, // Asegurarse de que es un string
            ]);
        }

        // marcar la cita como completada NO FUNCIONA AUN:()
        $cita = Citas::where('paciente_id', $request->paciente_id)
        ->where('doctor_id', $request->doctor_id)
        ->where('fecha', $request->fecha)
        ->where('hora', $request->hora)
        ->first();
        if ($cita) {
        $cita->update(['estado' => 'Completada']);
        }
    
        return redirect()->route('consultas.index')->with('success', 'Consulta registrada correctamente.');
    }

    //editar la cita
    public function editar($id): View
    {
        $consulta = Consultas::with(['signosVitales', 'paciente', 'doctor'])->findOrFail($id);
        $servicios = Servicios::all();
        $doctores = Doctores::all();
        return view('consultas.editar', compact('consulta', 'servicios', 'doctores'));
    }
    
    //actualizar la cita
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'talla' => 'required|integer',
            'temperatura' => 'required|numeric',
            'frecuencia_cardiaca' => 'required|integer',
            'saturacion_oxigeno' => 'required|integer',
        ]);
    
        $consulta = Consultas::findOrFail($id);
        $consulta->update([
            'motivo_consulta' => $request->motivo_consulta,
            'notas_padecimiento' => $request->notas_padecimiento,
        ]);
    
        $signosVitales = $consulta->signosVitales()->first();
        if ($signosVitales) {
            $signosVitales->update([
                'talla' => $request->talla,
                'temperatura' => $request->temperatura,
                'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
                'saturacion_oxigeno' => $request->saturacion_oxigeno,
            ]);
        }

        // actualizar las recetas
        foreach ($request->medicacion as $index => $medicacion) {
            $receta = $consulta->recetas[$index];
            $receta->update([
                'medicacion' => $medicacion,
                'cantidad_medicamento' => $request->cantidad_medicamento[$index],
                'frecuencia_medicamento' => $request->frecuencia_medicamento[$index],
                'duracion_medicamento' => $request->duracion_medicamento[$index],
                'notas_receta' => $request->notas_receta[$index],
            ]);
        }

        // actualizar los servicios
        foreach ($request->servicio as $index => $servicio) {
            $servicioConsulta = $consulta->serviciosConsulta[$index];
            $servicioConsulta->update([
                'servicio_id' => $servicio,
                'cantidad_servicio' => $request->cantidad_servicio[$index],
                'precio' => $request->precio[$index],
                'notas_servicio' => $request->notas_servicio[$index],
            ]);
        }
    
        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada correctamente.');
    }
    
}
    