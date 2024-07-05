<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiciosConsulta extends Model
{
    use HasFactory;

    // atributos que se pueden asignar masivamente
    protected $fillable = [
        'consulta_id',
        'servicio_id',
        'cantidad_servicio',
        'precio',
        'notas_servicio'
    ];

    // relación muchos a uno con Consultas
    public function consulta()
    {
        return $this->belongsTo(Consultas::class, 'consulta_id');
    }

    // relación muchos a uno con Servicios
    public function servicio()
    {
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }
}
