<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaTrabajo extends Model
{
    use HasFactory;

    protected $table = 'dias_trabajo';

    protected $fillable = ['doctor_id', 'dia'];

    // relación uno a muchos con Doctores
    public function doctor()
    {
        return $this->belongsTo(Doctores::class, 'doctor_id');
    }
}
