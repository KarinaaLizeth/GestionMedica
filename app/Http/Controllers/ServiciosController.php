<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 

class ServiciosController extends Controller
{
    // mostrar la vista principal con la lista de servicios
    public function index(): View
    {
        // obtener todos los servicios de la bd
        $servicios = Servicios::all();
        return view('servicios.servicios', ['servicios' => $servicios]);
    }

    // mostrar el formulario de edición para un servicio específico
    public function editar($id): View
    {
        // buscar el servicio por su id
        $servicio = Servicios::findOrFail($id);
        return view('servicios.editar', compact('servicio'));
    }
    
    // mostrar el formulario para crear un nuevo servicio
    public function crear(): View
    {
        // retornar la vista 'servicios.crear'
        return view('servicios.crear');
    }

    // validar y crear un nuevo servicio
    public function store(Request $request): RedirectResponse
    {
        // validar los datos del formulario
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'precio' => ['required', 'int'],
        ]);

        // crear un nuevo servicio con los datos validados
        $servicio = Servicios::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        return redirect()->route('servicios.index')->with('success', 'Nuevo servicio agregado.');
    }
    
    // validar y actualizar un servicio existente
    public function actualizar(Request $request, $id): RedirectResponse
    {
        // validar los datos del formulario
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'precio' => ['required', 'int'],
        ]);

        // buscar el servicio por su id
        $servicio = Servicios::findOrFail($id);
        // actualizar el servicio con los datos validados
        $servicio->update($request->all());

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado.');
    }
    
    // eliminar un servicio existente
    public function eliminar($id): RedirectResponse
    {
        // buscar el servicio por su id
        $servicio = Servicios::findOrFail($id);
        // eliminar el servicio de la bd
        $servicio->delete();

        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado.');
    }
}
