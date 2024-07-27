<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Secretarias extends Model
{
    use HasFactory, Notifiable;

    // atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'password',
        'telefono',   
        'role_id'  
    ];

    // atributos que son ocultos
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // atributos que son convertidos cuando se acceden a ellos
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // relación muchos a uno con Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
