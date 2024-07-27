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
use App\Models\Venta;
use App\Models\VentasServicios;

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

        return view('consultas.crear', compact('servicios', 'paciente', 'doctor', 'fecha', 'hora','cita'));
    }

    //validar y guardar nueva consulta
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'motivo_consulta' => 'required|string',
            'notas_padecimiento' => 'nullable|string',
            'temperatura' => 'required|integer|max:99',
            'talla' => 'required|integer|max:99',
            'frecuencia_cardiaca' => 'required|integer|max:99',
            'saturacion_oxigeno' => 'required|integer|max:99',
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
    
        // Crear la consulta
        $consulta = Consultas::create([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'cita_id' => $request->input('cita_id'),
            'motivo_consulta' => $request->motivo_consulta,
            'notas_padecimiento' => $request->notas_padecimiento,
           
        ]);
    
        // Crear los signos vitales
        SignosVitales::create([
            'consulta_id' => $consulta->id,
            'temperatura' => $request->temperatura,
            'talla' => $request->talla,
            'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
            'saturacion_oxigeno' => $request->saturacion_oxigeno,
        ]);
    
        // Crear las recetas
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
    
        // Inicializar el total de la venta
        $total = 0;

        // Crear los servicios de consulta y calcular el total de la venta
        foreach ($request->servicio as $index => $servicioId) {
            $cantidad = $request->cantidad_servicio[$index];
            $precio = $request->precio[$index];
            $subtotal = $cantidad * $precio;
            $total += $subtotal;

            ServiciosConsulta::create([
                'consulta_id' => $consulta->id,
                'servicio_id' => $servicioId,
                'cantidad_servicio' => $cantidad,
                'precio' => $precio,
                'notas_servicio' => $request->notas_servicio[$index],
            ]);
        }

        // Crear la venta
        $venta = Venta::create([
            'total' => $total,
            'consulta_id' => $consulta->id,  // asignar la venta a la consulta
        ]);

        // Guardar los detalles de los servicios en la tabla ventas_servicios
        foreach ($request->servicio as $index => $servicioId) {
            $cantidad = $request->cantidad_servicio[$index];
            $precio = $request->precio[$index];
            $subtotal = $cantidad * $precio;

            VentasServicios::create([
                'venta_id' => $venta->id,
                'servicio_id' => $servicioId,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'subtotal' => $subtotal,
            ]);
        }
    
        // Marcar la cita como completada (si existe)
        if ($request->has('cita_id')) {
            $cita = Citas::find($request->cita_id);
            if ($cita) {
                $cita->update(['estado' => 'completada']);
            }
        }

    
        return redirect()->route('consultas.index')->with('success', 'Consulta y venta registradas correctamente.');
    }
    public function completar($id)
    {
        $consulta = Consultas::findOrFail($id);

        // Marcar la cita relacionada como completada
        $cita = Citas::where('paciente_id', $consulta->paciente_id)
                    ->where('doctor_id', $consulta->doctor_id)
                    ->where('fecha', $consulta->fecha)
                    ->where('hora', $consulta->hora)
                    ->first();
        if ($cita) {
            $cita->update(['estado' => 'completada']);
        }

        return redirect()->route('consultas.index')->with('success', 'Consulta marcada como completada.');
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
            'talla' => 'required|integer|max:99',
            'temperatura' => 'required|integer|max:99',
            'frecuencia_cardiaca' => 'required|integer|max:99',
            'saturacion_oxigeno' => 'required|integer|max:99',
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
    
        // eliminar todas las recetas y recrearlas
        Receta::where('consulta_id', $consulta->id)->delete();
        foreach ($request->medicacion as $index => $medicacion) {
            Receta::create([
                'consulta_id' => $consulta->id,
                'medicacion' => $medicacion,
                'cantidad_medicamento' => $request->cantidad_medicamento[$index],
                'frecuencia_medicamento' => $request->frecuencia_medicamento[$index],
                'duracion_medicamento' => $request->duracion_medicamento[$index],
                'notas_receta' => $request->notas_receta[$index] ?? '',
            ]);
        }
    
        // eliminar todos los servicios de consulta y recrearlos
        ServiciosConsulta::where('consulta_id', $consulta->id)->delete();
        foreach ($request->servicio as $index => $servicio) {
            ServiciosConsulta::create([
                'consulta_id' => $consulta->id,
                'servicio_id' => $servicio,
                'cantidad_servicio' => $request->cantidad_servicio[$index],
                'precio' => $request->precio[$index],
                'notas_servicio' => $request->notas_servicio[$index] ?? '',
            ]);
        }
    
        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada correctamente.');
    }

    //en la vista de editar poder eliminar los servicios previamente agregados
    public function eliminarServicio($id)
    {
        $service = ServiciosConsulta::findOrFail($id);
        $service->delete();

        return response()->json(['success' => 'Servicio eliminado correctamente']);
    }
    //ver consultas
    public function ver($id)
    {
        $consulta = Consultas::with(['paciente', 'doctor', 'signosVitales', 'recetas', 'serviciosConsulta', 'venta.servicios'])->findOrFail($id);
        $cita = Citas::where('paciente_id', $consulta->paciente_id)
                     ->where('doctor_id', $consulta->doctor_id)
                     ->where('estado', '!=', 'Cancelada')
                     ->first();
        
        return view('consultas.ver', compact('consulta', 'cita'));
    }



    
}
    