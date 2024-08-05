<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
    'total',
    'consulta_id'
    ];

    public function servicios()
    {
        return $this->belongsToMany(Servicios::class, 'ventas_servicios', 'venta_id', 'servicio_id')
                    ->withPivot('cantidad', 'precio', 'subtotal')
                    ->withTimestamps();
    }
    public function consulta()
    {
        return $this->belongsTo(Consultas::class);
    }

}
