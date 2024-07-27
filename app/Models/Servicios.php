<?php

namespace App\Models;

use App\Models\Servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Servicios extends Model
{
    use HasFactory;

    // atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad'   
    ];

    // relación muchos a muchos con Consultas a través de la tabla pivot servicios_consulta
    public function consultas()
    {
        return $this->belongsToMany(Consultas::class, 'servicios_consulta', 'servicio_id', 'consulta_id');
    }

    // relación uno a muchos con ServiciosConsulta
    public function serviciosConsulta()
    {
        return $this->hasMany(ServiciosConsulta::class, 'consulta_id');
    }
}
