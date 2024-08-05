<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use App\Models\Venta;
use App\Models\Consultas;
use App\Models\VentasServicios;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('servicios')->get();
        return view('ventas.ventas', compact('ventas'));
    }

    public function crear()
    {
        $servicios = Servicios::all();
        return view('ventas.crear', compact('servicios'));
    }

    public function ver($id)
    {
        $venta = Venta::with('servicios', 'consulta')->findOrFail($id);
        $consulta = $venta->consulta;

        return view('ventas.ver', compact('venta', 'consulta'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'servicio' => 'required|array',
            'cantidad' => 'required|array',
            'precio' => 'required|array',
            'consulta_id' => 'nullable|exists:consultas,id',
        ]);

        $total = 0;
        $venta = Venta::create([
            'total' => $total,
            'consulta_id' => $request->consulta_id,
        ]);

        foreach ($request->servicio as $index => $servicioId) {
            $cantidad = $request->cantidad[$index];
            $precio = $request->precio[$index];
            $subtotal = $cantidad * $precio;
            $total += $subtotal;

            // Actualizar la cantidad del servicio
            $servicio = Servicios::findOrFail($servicioId);
            if ($servicio->cantidad < $cantidad) {
                return redirect()->back()->with('error', "No hay suficiente cantidad disponible para el servicio: {$servicio->nombre}");
            }
            $servicio->cantidad -= $cantidad;
            $servicio->save();

            VentasServicios::create([
                'venta_id' => $venta->id,
                'servicio_id' => $servicioId,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'subtotal' => $subtotal,
            ]);
        }

        $venta->update(['total' => $total]);

        return redirect()->route('ventas.index')->with('success', 'Venta realizada correctamente.');
    }
}
