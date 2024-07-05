<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'medicacion',
        'cantidad_medicamento',
        'frecuencia_medicamento',
        'duracion_medicamento',
        'notas_receta',
    ];

    // relación muchos a uno con Consultas
    public function consulta()
    {
        return $this->belongsTo(Consultas::class);
    }
}
