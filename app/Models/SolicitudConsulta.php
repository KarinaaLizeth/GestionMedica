<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudConsulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'paciente_id',
        'consulta_id',
        'aprobado',
    ];

    public function doctor()
    {
        return $this->belongsTo(MedicoColaborador::class, 'doctor_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }
}
