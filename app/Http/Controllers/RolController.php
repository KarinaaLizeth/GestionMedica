<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RolController extends Controller
{
    // método para mostrar la vista principal con la lista de roles
    public function index()
    {
        // obtener todos los roles de la base de datos
        $roles = Role::all();
        // retornar la vista 'roles.roles' con la lista de roles
        return view("roles.roles", compact('roles'));
    }

    // método para mostrar el formulario de creación de roles
    public function crear()
    {
        // retornar la vista 'roles.crear'
        return view("roles.crear");
    }

    // método para almacenar un nuevo rol en la base de datos
    public function store(Request $request)
    {
        // validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles',
        ]);

        // crear un nuevo registro de rol con los datos validados
        Role::create([
            'nombre' => $request->nombre,
        ]);

        // redirigir a la vista principal de roles con un mensaje de éxito
        return redirect()->route('rol.index')->with('success', 'Rol agregado exitosamente');
    }

    // método para mostrar el formulario de edición de un rol existente
    public function editar($id)
    {
        // buscar el rol por su ID o lanzar un error si no se encuentra
        $rol = Role::findOrFail($id);
        // retornar la vista 'roles.editar' con los datos del rol
        return view('roles.editar', compact('rol'));
    }

    // método para actualizar los datos de un rol en la base de datos
    public function actualizar(Request $request, $id)
    {
        // validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $id,
        ]);

        // buscar el rol por su ID o lanzar un error si no se encuentra
        $rol = Role::findOrFail($id);
        // actualizar el rol con los datos validados
        $rol->update([
            'nombre' => $request->nombre,
        ]);

        // redirigir a la vista principal de roles con un mensaje de éxito
        return redirect()->route('rol.index')->with('success', 'Rol actualizado exitosamente');
    }

    // método para eliminar un rol de la base de datos
    public function eliminar($id)
    {
        // buscar el rol por su ID o lanzar un error si no se encuentra
        $rol = Role::findOrFail($id);
        // eliminar el rol
        $rol->delete();

        // redirigir a la vista principal de roles con un mensaje de éxito
        return redirect()->route('rol.index')->with('success', 'Rol eliminado exitosamente');
    }
}
