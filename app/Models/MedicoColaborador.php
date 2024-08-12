<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicoColaborador extends Model
{
    use HasFactory;

    protected $table = 'medico_colaboradores';
    
    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'password',
        'telefono',
    ];

    protected $hidden = [
        'password',
    ];
}
