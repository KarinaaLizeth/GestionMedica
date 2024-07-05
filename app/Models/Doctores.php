<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Doctores extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'doctores';

    protected $fillable = [
        'nombres', 
        'apellidos', 
        'correo', 
        'password', 
        'telefono', 
        'especialidad', 
        'precio_consulta', 
        'duracion_cita'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // relación uno a muchos con DiaTrabajo
    public function diasTrabajo()
    {
        return $this->hasMany(DiaTrabajo::class, 'doctor_id');
    }

    // relación uno a muchos con Horario
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'doctor_id');
    }

    // relación uno a muchos con Citas
    public function citas()
    {
        return $this->hasMany(Citas::class);
    }

    // relación muchos a muchos con Role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'doctor_roles', 'doctor_id', 'role_id');
    }
    
    // método para verificar si el doctor tiene un rol específico
    public function hasRole($roleName)
    {
        return $this->roles()->where('nombre', $roleName)->exists();
    }

}
