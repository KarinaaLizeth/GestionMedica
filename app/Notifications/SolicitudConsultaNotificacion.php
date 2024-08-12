<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudConsultaNotificacion extends Notification
{
    use Queueable;

    protected $solicitante;
    protected $consulta;

    public function __construct($solicitante, $consulta)
    {
        $this->solicitante = $solicitante;
        $this->consulta = $consulta;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'solicitante' => $this->solicitante->nombres . ' ' . $this->solicitante->apellidos,
            'paciente' => $this->consulta->paciente->nombres . ' ' . $this->consulta->paciente->apellidos,
            'consulta_id' => $this->consulta->id,
            'message' => $this->solicitante->nombres . ' ha solicitado ver la consulta de ' . $this->consulta->paciente->nombres,
        ];
    }
}
