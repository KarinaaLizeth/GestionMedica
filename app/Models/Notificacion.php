<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones'; 
    protected $fillable = [
        'consulta_id',
        'tipo',
        'user_id',
        'solicitante_id',
        'solicitante_type',
        'mensaje',
        'leido',
        ];

    // Relación con los usuarios
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con los pacientes o doctores según el tipo
    public function related()
    {
        return $this->morphTo();
    }
    public function solicitante()
    {
        return $this->morphTo();
    }

    public function consulta()
    {
        return $this->belongsTo(Consultas::class, 'consulta_id');
    }

}
