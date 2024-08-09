<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudHistorial;
use App\Models\Pacientes;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SolicitudHistorialNotificacion; 
use App\Models\Notificacion; 
use App\Models\Doctores;
use App\Models\Citas;
use App\Models\Consultas;
use Illuminate\Support\Facades\Mail; 


class SolicitudHistorialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'telefono' => 'required|numeric',
        ]);
    
        $paciente = Pacientes::where('correo', $request->email)->first();
    
        if (!$paciente) {
            return redirect()->back()->with('error', 'Correo incorrecto.');
        }
    
        if ($paciente->telefono != $request->telefono) {
            return redirect()->back()->with('error', 'Teléfono incorrecto.');
        }
    
        $solicitud = SolicitudHistorial::create([
            'email' => $request->email,
            'telefono' => $request->telefono,
            'aprobado' => false,
        ]);
    
        // Notificar al administrador
        Notification::route('mail', 'admin@example.com')->notify(new SolicitudHistorialNotificacion($solicitud));
    
        $notificaciones = [];
        $doctores = Doctores::all();
        $nombreCompleto = "{$paciente->nombres} {$paciente->apellidos}";
        foreach ($doctores as $doctor) {
            $notificaciones[] = [
                'tipo' => 'solicitud_historial',
                'user_id' => $doctor->id,
                'solicitante_id' => $paciente->id,
                'mensaje' => "{$nombreCompleto} ha solicitado su historia de consultas",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Notificacion::insert($notificaciones);


        return redirect()->back()->with('success', 'Solicitud enviada con éxito.');
    }

    public function index()
    {
        $solicitudes = SolicitudHistorial::all();
        return view('admin.solicitudes', compact('solicitudes'));
    }
    public function verHistorial($pacienteId)
    {
        // Obtener el paciente
        $paciente = Pacientes::findOrFail($pacienteId);

        // Obtener citas y consultas del paciente
        $citas = Citas::where('paciente_id', $paciente->id)->with('doctor')->get();
        $consultas = Consultas::where('paciente_id', $paciente->id)->with('doctor')->get();

        return view('historial.historial_publico', compact('citas', 'consultas', 'paciente'));
    }

    public function aprobar($id)
    {
        $solicitud = SolicitudHistorial::find($id);
        $paciente = Pacientes::where('correo', $solicitud->email)->first(); // Asegúrate de obtener el paciente

        if (!$paciente) {
            return redirect()->back()->with('error', 'Paciente no encontrado.');
        }

        $solicitud->aprobado = true; // Cambia el estado a aprobado
        $solicitud->save();

        // Generar el enlace para que el paciente vea su historial
        $link = route('historial.ver', ['pacienteId' => $paciente->id]);

        // Enviar correo al paciente
        Mail::send('emails.historial_disponible', ['link' => $link, 'paciente' => $paciente], function ($message) use ($paciente) {
            $message->to($paciente->correo)
                    ->subject('Tu historial médico ya está disponible');
        });

        return redirect()->back()->with('success', 'El historial ha sido aprobado y el paciente ha sido notificado.');
    }
    
    
    public function denegar($id)
    {
        $solicitud = SolicitudHistorial::find($id);
        $solicitud->aprobado = false; // Cambia el estado a denegado
        $solicitud->save();
    
        return redirect()->back()->with('success', 'Solicitud denegada con éxito.');
    }
    
    public function marcarComoLeidas()
    {
        $notificaciones = Auth::user()->unreadNotifications; // Obtener las notificaciones no leídas
        $notificaciones->markAsRead(); // Marcarlas como leídas

        return response()->json(['status' => 'success']);
    }



}
