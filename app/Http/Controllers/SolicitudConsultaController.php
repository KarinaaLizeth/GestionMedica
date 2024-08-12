<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Consultas;
use App\Models\SolicitudConsulta;
use App\Models\MedicoColaborador; // Asegúrate de incluir este modelo
use App\Models\User;
use App\Notifications\SolicitudConsultaNotificacion;
use Illuminate\Support\Facades\Notification;
use App\Models\Notificacion;  

class SolicitudConsultaController extends Controller
{
    public function solicitar(Request $request)
    {
        $consultaId = $request->input('consulta_id');
        $consulta = Consultas::findOrFail($consultaId);
    
        // Supongamos que estás autenticado como MedicoColaborador
        $medicoColaborador = MedicoColaborador::where('correo', Auth::user()->email)->firstOrFail();
    
        $solicitud = SolicitudConsulta::create([
            'doctor_id' => $medicoColaborador->id, // Aquí usas el ID del modelo MedicoColaborador
            'paciente_id' => $consulta->paciente_id,
            'consulta_id' => $consulta->id,
            'aprobado' => false,
        ]);

        // Crear la notificación en la tabla `notificaciones`
        Notificacion::create([
            'tipo' => 'solicitud_consulta',
            'user_id' => $consulta->doctor_id,
            'solicitante_id' => $medicoColaborador->id, 
            'solicitante_type' => MedicoColaborador::class, // Aquí indicas el tipo del solicitante
            'mensaje' => $medicoColaborador->nombres . ' ha solicitado ver la consulta de ' . $consulta->paciente->nombres,
            'leido' => 0,
        ]);

        return redirect()->back()->with('success', 'Solicitud de consulta enviada correctamente.');
    }

    public function verSolicitudes()
    {
        $solicitudes = Notificacion::where('user_id', Auth::id())
                                    ->where('tipo', 'solicitud_consulta')
                                    ->get();
                                    
    
        return view('admin.solicitudes_consultas', compact('solicitudes'));
    }
    
    public function aprobar($solicitudId)
    {
        $solicitud = SolicitudConsulta::findOrFail($solicitudId);
        $solicitud->update(['aprobado' => true]);

        return redirect()->back()->with('success', 'Solicitud aprobada correctamente.');
    }

    public function rechazar($solicitudId)
    {
        $solicitud = SolicitudConsulta::findOrFail($solicitudId);
        $solicitud->delete();

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }
}
