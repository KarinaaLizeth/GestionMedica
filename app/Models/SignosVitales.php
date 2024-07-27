<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignosVitales extends Model
{
    use HasFactory;

    // atributos que se pueden asignar masivamente
    protected $fillable = [
        'consulta_id',
        'temperatura',
        'talla',
        'frecuencia_cardiaca',
        'saturacion_oxigeno',
    ];

    // relación muchos a uno con Consultas
    public function consulta()
    {
        return $this->belongsTo(Consultas::class, 'consulta_id');
    }
}
