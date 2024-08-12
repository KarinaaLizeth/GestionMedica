<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones'; 
    protected $fillable = [
        'tipo',
        'user_id',
        'solicitante_id',
        'solicitante_type', // No olvides incluir este campo
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


}
