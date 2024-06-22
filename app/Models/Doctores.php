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

    public function diasTrabajo()
    {
        return $this->hasMany(DiaTrabajo::class, 'doctor_id');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'doctor_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($doctor) {
            $doctor->diasTrabajo()->delete();
            $doctor->horarios()->delete();
        });
    }
}
