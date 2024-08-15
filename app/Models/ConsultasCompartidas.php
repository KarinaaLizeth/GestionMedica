<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultasCompartidas extends Model
{
    use HasFactory;
    protected $table = 'consultas_compartidas';

    protected $fillable = [
        'consulta_id',
        'medico_colaborador_id',
    ];
    
    public function consulta()
    {
        return $this->belongsTo(Consultas::class, 'consulta_id');
    }
    

    public function colaborador()
    {
        return $this->belongsTo(MedicoColaborador::class, 'medico_colaborador_id');
    }
}
