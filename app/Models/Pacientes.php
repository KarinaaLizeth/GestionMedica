<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Pacientes extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'telefono_emergencia',
        'genero',
        'fecha_nacimiento',
        'altura',
        'peso',
        'sangre',
        'alergias',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // relación uno a muchos con Citas
    public function citas()
    {
        return $this->hasMany(Citas::class, 'paciente_id');
    }
}
