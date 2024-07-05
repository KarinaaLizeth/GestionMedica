<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = ['doctor_id', 'hora_inicio', 'hora_fin'];

    // relación uno a muchos con Doctores
    public function doctor()
    {
        return $this->belongsTo(Doctores::class, 'doctor_id');
    }
}
