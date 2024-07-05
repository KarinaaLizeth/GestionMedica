<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    // relación muchos a muchos con Doctores
    public function doctores()
    {
        return $this->belongsToMany(Doctores::class, 'doctor_roles');
    }
}
