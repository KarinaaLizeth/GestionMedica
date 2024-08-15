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
use App\Models\MedicoColaborador;
use App\Models\Notificacion;
use App\Models\User;
use App\Models\ConsultasCompartidas;
use App\Notifications\SolicitudConsultaNotificacion; 
use Illuminate\Support\Facades\Notification;

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
            'servicio' => 'nullable|array',
            'cantidad_servicio' => 'nullable|array',
            'precio' => 'nullable|array',
            'notas_servicio' => 'nullable|string'
        ]);
    
        try {
            // Verificar la cantidad disponible de cada servicio antes de crear la consulta
            if ($request->has('servicio') && !empty(array_filter($request->servicio))) {
                foreach ($request->servicio as $index => $servicioId) {
                    if (empty($servicioId)) {
                        continue; // Saltar servicios vacíos
                    }
    
                    $servicio = Servicios::findOrFail($servicioId);
                    $cantidadSolicitada = $request->cantidad_servicio[$index];
                    if (!is_null($servicio->cantidad) && $servicio->cantidad < $cantidadSolicitada) {
                        return redirect()->back()->withErrors(["No hay suficiente cantidad disponible para el servicio: {$servicio->nombre}"]);
                    }
                }
            }

             // Crear la consulta
            $consulta = Consultas::create([
                'paciente_id' => $request->paciente_id,
                'doctor_id' => $request->doctor_id,
                'cita_id' => $request->input('cita_id'),
                'motivo_consulta' => preg_replace('/<p>(.*?)<\/p>/', '$1', $request->motivo_consulta),
                'notas_padecimiento' => preg_replace('/<p>(.*?)<\/p>/', '$1', $request->notas_padecimiento),
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
            if ($request->has('servicio') && !empty(array_filter($request->servicio))) {
                foreach ($request->servicio as $index => $servicioId) {
                    if (empty($servicioId)) {
                        continue; // Saltar servicios vacíos
                    }
    
                    $servicio = Servicios::findOrFail($servicioId);
                    $cantidad = $request->cantidad_servicio[$index];
                    $precio = $request->precio[$index];
                    $subtotal = $cantidad * $precio;
                    $total += $subtotal;
    
                    if (!is_null($servicio->cantidad)) {
                        $servicio->cantidad -= $cantidad;
                        $servicio->save();
                    }
    
                    ServiciosConsulta::create([
                        'consulta_id' => $consulta->id,
                        'servicio_id' => $servicioId,
                        'cantidad_servicio' => $cantidad,
                        'precio' => $precio,
                        'notas_servicio' => $request->notas_servicio[$index] ?? '',
                    ]);
                }
    
                // Crear la venta si hay servicios
                $venta = Venta::create([
                    'total' => $total,
                    'consulta_id' => $consulta->id,  // asignar la venta a la consulta
                ]);
    
                // Guardar los detalles de los servicios en la tabla ventas_servicios
                foreach ($request->servicio as $index => $servicioId) {
                    if (empty($servicioId)) {
                        continue; // Saltar servicios vacíos
                    }
    
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
            }
    
            // Marcar la cita como completada (si existe)
            if ($request->has('cita_id')) {
                $cita = Citas::find($request->cita_id);
                if ($cita) {
                    $cita->update(['estado' => 'completada']);
                }
            }
    
            return redirect()->route('consultas.index')->with('success', 'Consulta y venta registradas correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
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
        $cita = Citas::find($consulta->cita_id);
    
        // Obtener los comentarios si la consulta fue compartida
        $consultaCompartida = \DB::table('consultas_compartidas')
            ->where('consulta_id', $consulta->id)
            ->where('medico_principal_id', auth()->id())
            ->first();
    
        return view('consultas.ver', compact('consulta', 'cita', 'consultaCompartida'));
    }
    
    

    public function verConsultasPorPaciente($pacienteId)
    {
        $paciente = Pacientes::findOrFail($pacienteId);
        $consultas = Consultas::where('paciente_id', $paciente->id)->with('doctor')->get();

        return view('medico_colaborador.historial_consultas', compact('consultas', 'paciente'));
    }

    public function mostrarFormularioCompartir($id)
    {
        $consulta = Consultas::findOrFail($id);
        $medicoColaboradores = MedicoColaborador::all();  // Obtener todos los colaboradores
    
        return view('consultas.compartir', compact('consulta', 'medicoColaboradores'));
    }
    public function consultasRecibidas()
    {
        $colaborador = MedicoColaborador::where('correo', auth()->user()->email)->first();
    
        if (!$colaborador) {
            return redirect()->route('dashboard')->with('error', 'Colaborador no encontrado.');
        }
    
        // Obtener las consultas compartidas correspondientes al colaborador autenticado
        $consultas = \DB::table('consultas_compartidas')
            ->join('consultas', 'consultas.id', '=', 'consultas_compartidas.consulta_id')
            ->join('pacientes', 'pacientes.id', '=', 'consultas.paciente_id')
            ->join('users as doctores', 'doctores.id', '=', 'consultas.doctor_id')
            ->where('consultas_compartidas.medico_colaborador_id', $colaborador->id)
            ->select('consultas.*', 'pacientes.nombres as paciente_nombres', 'pacientes.apellidos as paciente_apellidos', 'doctores.name as doctor_nombres')
            ->get();
    
        return view('medico_colaborador.consultas_recibidas', compact('consultas'));
    }
    
    // Función para compartir la consulta
    public function compartirConsulta(Request $request, $id)
    {
        $consulta = Consultas::findOrFail($id);
        $medicoColaborador = MedicoColaborador::findOrFail($request->input('medico_colaborador_id'));
    
        // Obtener el user_id correspondiente al colaborador desde la tabla users
        $user = User::where('email', $medicoColaborador->correo)->first();
    
        if ($user) {
            Notificacion::create([
                'consulta_id' => $consulta->id,
                'user_id' => $user->id, // Usar el user_id del registro en la tabla users
                'tipo' => 'consulta_compartida',
                'mensaje' => 'Se te ha compartido una nueva consulta.',
                'leido' => false,
            ]);

            \DB::table('consultas_compartidas')->insert([
                'consulta_id' => $consulta->id,
                'medico_colaborador_id' => $medicoColaborador->id,
                'medico_principal_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            return redirect()->route('consultas.index')->with('success', 'Consulta compartida exitosamente.');
        } else {
            return redirect()->route('consultas.index')->with('error', 'Error al encontrar el usuario del colaborador.');
        }
    }

    public function devolverConsulta(Request $request, $id)
    {
        // Obtener el correo del usuario autenticado
        $userEmail = auth()->user()->email;
    
        // Buscar el colaborador en la tabla medico_colaboradores por correo
        $colaborador = \DB::table('medico_colaboradores')
                          ->where('correo', $userEmail)
                          ->first();
    
        // Verificar si se encontró el colaborador
        if (!$colaborador) {
            return redirect()->route('consultas.compartidas')->with('error', 'No se encontró el colaborador.');
        }
    
        // Obtener la consulta compartida con el ID del colaborador encontrado
        $consultaCompartida = \DB::table('consultas_compartidas')
                                 ->where('consulta_id', $id)
                                 ->where('medico_colaborador_id', $colaborador->id)
                                 ->first();
    
        // Verificar si se encontró la consulta compartida
        if ($consultaCompartida) {
            \DB::table('consultas_compartidas')
                ->where('id', $consultaCompartida->id)
                ->update([
                    'comentarios' => $request->input('comentarios'),
                    'updated_at' => now(),
                ]);
    
            Notificacion::create([
                'consulta_id' => $consultaCompartida->consulta_id,
                'user_id' => $consultaCompartida->medico_principal_id,
                'tipo' => 'consulta_devuelta',
                'mensaje' => 'El colaborador ha devuelto la consulta con comentarios.',
                'leido' => false,
            ]);
    
            // Agregar SweetAlert de éxito
            return redirect()->route('consultas.compartidas')->with('success', 'Consulta devuelta exitosamente.')
                    ->with('alert', 'consulta_devuelta');
        } else {
            return redirect()->route('consultas.compartidas')->with('error', 'No se encontró la consulta compartida.');
        }
    }  
    
}
    