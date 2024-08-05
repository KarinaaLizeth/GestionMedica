<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\Doctores;
use App\Models\Citas;
use App\Models\Horario;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CitasController extends Controller
{
    /*función que retorns la vista de citas, compact es para convertir $citas
    en un array con los datos del paciente y el doctor */
    public function index()
    {
        $citas = Citas::with(['paciente', 'doctor'])->get();
        return view('citas.citas', ['citas' => $citas]);
    }
    
    /*
    función que crea una nueva cita, se utiliza el request para obtener los datos
    diferencia entre hacerlo sin el compact
    public function lista(Request $request)
    {
        $filtro = $request->input('filtro', 'hoy');
        $citas = $this->filtrarCitas($filtro);
        
        return view('citas.lista_citas', [
            'citas' => $citas,
            'filtro' => $filtro
        ]);
    }
    */
    /*retornar vista de lista_citas con datos de la citas y el filtro
    se obtiene el filtro de hoy,completada, cancelara, por defecto se pasa el de hoy*/
    public function lista(Request $request)
    {
        $this->cancelarCitasPasadas();

        $filtro = $request->input('filtro', 'hoy');
        $citas = $this->filtrarCitas($filtro); //obtener las citas filtradas
    
        return view('citas.lista_citas', compact('citas', 'filtro'));
    }
    
    /*función para retornar la vista de crear obteniendo los pacientes y dcotores */
    public function crear()
    {
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
        return view('citas.crear', compact('pacientes', 'doctores'));
    }
    
    /*función para validar y registrar los datos ingresados de la cita */
    public function store(Request $request)
    {
        //validar datos ingresados
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
        ]);

        /* verificar disponibilidad del doctor
        lo busca por su ID*/
        $doctor = Doctores::findOrFail($request->doctor_id);
        $diaSemana = date('l', strtotime($request->fecha));//convertir la fecha a un día para verificar que el doctor este trabajando ese dpia
        $dias = [
            'Sunday' => 'Domingo',
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
        ];
        $diaSemana = $dias[$diaSemana]; //pasar de inglés a español
        $disponible = $doctor->diasTrabajo()->where('dia', $diaSemana)->exists(); //verificar si el doctor esta trabajando ese día

        if (!$disponible) {
            return back()->withErrors(['El doctor no está disponible ese día'])->withInput();
        }
        //verificar si la hora ya está ocupada filtrando las citas, fecha y hora
        $horaOcupada = Citas::where('doctor_id', $request->doctor_id)
                            ->where('fecha', $request->fecha)
                            ->where('hora', $request->hora)
                            ->where('estado', 'En proceso')
                            ->exists();
        //si la cita esta ocupada manda el aviso
        if ($horaOcupada) {
            return back()->withErrors(['El doctor ya tiene una cita programada a esa hora'])->withInput();
        }

        // Verificar que la hora no sea pasada
        $fechaHoraCita = Carbon::parse("{$request->fecha} {$request->hora}");
        if ($fechaHoraCita->isPast()) {
            return back()->withErrors(['No se puede agendar citas en horas pasadas'])->withInput();
        }

        //crear la cita en la base de datos
        Citas::create([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'En proceso',
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita agendada exitosamente.');
    }

    //función para devolver la vita editar la cita obteniendo los datos de la misma
    public function editar($id)
    {
        $cita = Citas::findOrFail($id);
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
        return view('citas.editar', compact('cita', 'pacientes', 'doctores'));
    }

    //funicón para validar que los datos de la cita actualizada sean correctos
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'fecha' => 'required|date',
            'hora' => 'required',
        ]);

        $cita = Citas::findOrFail($id);

        $doctor = Doctores::findOrFail($request->doctor_id);
        $diaSemana = date('l', strtotime($request->fecha));
        $dias = [
            'Sunday' => 'Domingo',
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
        ];
        $diaSemana = $dias[$diaSemana];
        $disponible = $doctor->diasTrabajo()->where('dia', $diaSemana)->exists();

        if (!$disponible) {
            return back()->withErrors(['El doctor no está disponible ese día']);
        }

        $horaOcupada = Citas::where('doctor_id', $request->doctor_id)
                            ->where('fecha', $request->fecha)
                            ->where('hora', $request->hora)
                            ->where('id', '!=', $id)
                            ->where('estado', 'En proceso') 
                            ->exists();

        if ($horaOcupada) {
            return back()->withErrors(['El doctor ya tiene una cita programada a esa hora']);
        }

        $cita->update([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'En proceso',
        ]);

        return redirect()->route('citas.lista')->with('success', 'Cita actualizada exitosamente.');
    }

    //función para eliminar una cita
    public function eliminar($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada exitosamente.');
    }

    //función que cambiar el estado de la cita 
    public function cambiarEstado($id, $estado)
    {
        $cita = Citas::findOrFail($id);
        $cita->estado = $estado;
        $cita->save();
    
        return redirect()->route('citas.lista')->with('success', 'El estado de la cita ha sido actualizado.');
    }

    /* cancelar citas que están en progreso y que ya ha pasado la fecha */
    public function cancelarCitasPasadas()
    {
        $now = Carbon::now();
        Citas::where('estado', 'En proceso')
             ->where(function($query) use ($now) {
                 $query->where('fecha', '<', $now->toDateString())
                       ->orWhere(function($query) use ($now) {
                           $query->where('fecha', '=', $now->toDateString())
                                 ->where('hora', '<', $now->toTimeString());
                       });
             })
             ->update(['estado' => 'Cancelada']);
    }
    
    
    //función para filtrar las citas por estado o día
    public function filtrarCitas($filtro)
    {
        switch ($filtro) {
            case 'hoy':
                return Citas::with(['paciente', 'doctor'])->whereDate('fecha', Carbon::today())->paginate(10);
            case 'en_proceso':
                return Citas::with(['paciente', 'doctor'])->where('estado', 'En proceso')->paginate(10);
            case 'completadas':
                return Citas::with(['paciente', 'doctor'])->where('estado', 'completada')->paginate(10);
            case 'canceladas':
                return Citas::with(['paciente', 'doctor'])->where('estado', 'cancelada')->paginate(10);
            default:
                return Citas::with(['paciente', 'doctor'])->paginate(10);
        }
    }

    //obtener los horarios disponibles del doctor
    public function getHorariosDisponibles(Request $request)
    {
        $doctorId = $request->query('doctor_id');
        $fecha = $request->query('fecha');
        $citaId = $request->query('cita_id'); // Obtener el ID de la cita si está editando
    
        $diaSemana = date('l', strtotime($fecha));
        $dias = [
            'Sunday' => 'Domingo',
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
        ];
        $diaSemana = $dias[$diaSemana];
    
        $horariosDisponibles = Horario::where('doctor_id', $doctorId)
                                      ->whereHas('doctor.diasTrabajo', function($query) use ($diaSemana) {
                                          $query->where('dia', $diaSemana);
                                      })
                                      ->get(['hora_inicio', 'hora_fin']);
    
        $doctor = Doctores::findOrFail($doctorId);
    
        $citasReservadasQuery = Citas::where('doctor_id', $doctorId)
                                     ->where('fecha', $fecha)
                                     ->where('estado', 'En proceso');
    
        if ($citaId) {
            $citasReservadasQuery->where('id', '!=', $citaId);
        }
    
        $citasReservadas = $citasReservadasQuery->pluck('hora')->toArray();
    
        $citasReservadasConDuracion = [];
        foreach ($citasReservadas as $cita) {
            $startTime = Carbon::parse($cita);
            $endTime = $startTime->copy()->addMinutes($doctor->duracion_cita);
            while ($startTime < $endTime) {
                $citasReservadasConDuracion[] = $startTime->format('H:i');
                $startTime->addMinutes(1);
            }
        }
    
        return response()->json([
            'horarios' => $horariosDisponibles,
            'duracion_cita' => $doctor->duracion_cita,
            'citasReservadas' => $citasReservadasConDuracion
        ]);
    }
    
    
    
    public function getCitasEventos()
    {
        // obtener  las citas  por fecha y contar el número total de citas
        $citas = Citas::select('fecha', \DB::raw('count(*) as total'))->groupBy('fecha')->get();
    
        // mapear las citas para crear un array de eventos
        $eventos = $citas->map(function ($cita) {
            return [
                'title' => $cita->total . ' Cita(s)', 
                'start' => $cita->fecha, 
                'allDay' => true, 
            ];
        });
    
        return response()->json($eventos);
    }
    
    //obtener las citas de una fecha especifica
    public function getCitasPorDia(Request $request)
    {
        $fecha = $request->query('fecha');
        $citas = Citas::with(['paciente', 'doctor'])->whereDate('fecha', $fecha)->get();

        return response()->json(['citas' => $citas]);

        /*"citas": [
            {
            "id": 1,
            "paciente_id": 1,
            "doctor_id": 1,
            "fecha": "2024-06-23",
            "hora": "10:00:00",
            "estado": "En proceso",
            "paciente": { ... },
            "doctor": { ... }
            }
        */
    }
    
    public function actualizarFecha(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
        ]);

        $cita = Citas::findOrFail($id);
        $cita->fecha = $request->fecha;
        $cita->save();

        return response()->json(['success' => true]);
    }

    
}
