<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'doctor_id',
        'motivo_consulta',
        'notas_padecimiento',
        'cita_id',
    ];

    // relación uno a muchos con Pacientes
    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }

    // relación uno a muchos con Doctores
    public function doctor()
    {
        return $this->belongsTo(Doctores::class);
    }

    // relación uno a muchos con SignosVitales
    public function signosVitales()
    {
        return $this->hasMany(SignosVitales::class, 'consulta_id');
    }

    // relación uno a muchos con Recetas
    public function recetas()
    {
        return $this->hasMany(Receta::class, 'consulta_id');
    }

    // relación uno a muchos con ServiciosConsulta
    public function serviciosConsulta()
    {
        return $this->hasMany(ServiciosConsulta::class, 'consulta_id');
    }

    public function venta()
    {
        return $this->hasOne(Venta::class, 'consulta_id');
    }

    public function cita()
    {
        return $this->belongsTo(Citas::class, 'cita_id'); 
    }
    
}
