<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion; 
class NotificacionesController extends Controller
{
    public function getRedirectRoute($notificacion)
    {
        if ($notificacion->tipo === 'solicitud_consulta') {
            return route('admin.solicitudes_consultas');
        } elseif ($notificacion->tipo === 'solicitud_historial') {
            return route('admin.solicitudes');
        }

        return route('dashboard');
    }

    public function marcarComoLeidas($id)
    {

        $notificacion = Notificacion::findOrFail($id);
        $notificacion->leido = true;
        $notificacion->save();
    
        $redirectRoute = $this->getRedirectRoute($notificacion);
    
        return redirect($redirectRoute);
    }
    
 
}
