<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SolicitudHistorial;

class SolicitudHistorialNotificacion extends Notification
{
    use Queueable;

    protected $solicitud;

    public function __construct(SolicitudHistorial $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Nueva solicitud de historial.')
                    ->action('Ver Solicitud', url('/admin/solicitudes'))
                    ->line('Correo: ' . $this->solicitud->email)
                    ->line('Teléfono: ' . $this->solicitud->telefono);
    }
}
