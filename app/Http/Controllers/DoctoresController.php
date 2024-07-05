<?php

namespace App\Http\Controllers;

use App\Models\Doctores;
use App\Models\DiaTrabajo;
use App\Models\Horario;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DoctoresController extends Controller
{
    // mostrar todos los doctores con sus días de trabajo y horarios
    public function index()
    {
        $doctores = Doctores::with(['diasTrabajo', 'horarios'])->get();
        return view('doctores.doctores', compact('doctores'));
    }

    // mostrar formulario para crear un nuevo doctor
    public function crear()
    {
        return view('doctores.crear');
    }

    // listar todos los doctores
    public function lista()
    {
        $doctores = Doctores::all();
        return view('doctores.lista_doctores', compact('doctores'));
    }

    // guardar un nuevo doctor en la bd
    public function store(Request $request)
    {
        // validar datos del formulario
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:doctores',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'required|numeric',
            'especialidad' => 'required|string|max:255',
            'precio_consulta' => 'required|numeric',
            'duracion_cita' => 'required|integer|min:10|max:60',
            'dias_disponibles' => 'required|array',
            'available_time_from' => 'required|array',
            'available_time_to' => 'required|array',
        ]);

        // crear el doctor con los datos validados
        $doctor = Doctores::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
            'precio_consulta' => $request->precio_consulta,
            'duracion_cita' => $request->duracion_cita,
            'is_admin' => 'nullable|boolean'
        ]);

        // Asignar rol de doctor
        /* buscar el rol de doctor en la tabla de roles, ignorando mayúsculas/minúsculas
            si encuentra el rol, lo asigna al doctor recién creado
            si no encuentra el rol, redirige con un mensaje de error
         */
        $role = Role::whereRaw('LOWER(nombre) = ?', ['doctor'])->first();
        if ($role) {
            $doctor->roles()->attach($role->id);
        } else {
            return redirect()->route('doctores.index')->with('error', 'Error: El rol de doctor no existe.');
        }

        // Asignar rol de administrador si está marcado
        /*
            si el campo is_admin está marcado en el formulario,
            busca el rol de admin y lo asigna al doctor
         */
        if ($request->has('is_admin') && $request->is_admin) {
            $roleAdmin = Role::whereRaw('LOWER(nombre) = ?', ['admin'])->first();
            if ($roleAdmin) {
                $doctor->roles()->attach($roleAdmin);
            }
        }

        // crear los días de trabajo del doctor
        /*
          por cada día disponible seleccionado en el formulario,
          crea un registro en la tabla 'dias_trabajo' asociándolo con el doctor
         */
        foreach ($request->dias_disponibles as $dia) {
            DiaTrabajo::create([
                'doctor_id' => $doctor->id,
                'dia' => $dia,
            ]);
        }

        // crear los horarios del doctor
        /*
            por cada par de tiempos de inicio y fin proporcionados en el formulario,
            crea un registro en la tabla 'horarios' asociándolo con el doctor
         */
        for ($i = 0; $i < count($request->available_time_from); $i++) {
            Horario::create([
                'doctor_id' => $doctor->id,
                'hora_inicio' => $request->available_time_from[$i],
                'hora_fin' => $request->available_time_to[$i],
            ]);
        }

        return redirect()->route('doctores.index')->with('success', 'Doctor registrado exitosamente');
    }

    // mostrar formulario para editar un doctor
    public function editar($id)
    {
        $doctor = Doctores::with(['diasTrabajo', 'horarios'])->findOrFail($id);
        return view('doctores.editar', compact('doctor'));
    }

    // actualizar datos de un doctor
    public function actualizar(Request $request, $id)
    {
        // validar datos del formulario
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:doctores,correo,' . $id,
            'telefono' => 'required|numeric',
            'especialidad' => 'required|string|max:255',
            'precio_consulta' => 'required|numeric',
            'duracion_cita' => 'required|integer|min:10|max:60',
            'dias_disponibles' => 'required|array',
            'available_time_from' => 'required|array',
            'available_time_to' => 'required|array',
        ]);

        // encontrar el doctor por ID y actualizar sus datos
        $doctor = Doctores::findOrFail($id);
        $doctor->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
            'precio_consulta' => $request->precio_consulta,
            'duracion_cita' => $request->duracion_cita,
        ]);

        // actualizar días de trabajo del doctor
        /*
          eliminar todos los registros de días de trabajo del doctor
          y crear nuevos registros basados en los datos del formulario
         */
        DiaTrabajo::where('doctor_id', $doctor->id)->delete();
        foreach ($request->dias_disponibles as $dia) {
            DiaTrabajo::create([
                'doctor_id' => $doctor->id,
                'dia' => $dia,
            ]);
        }

        // actualizar horarios del doctor
        /*
          eliminar todos los registros de horarios del doctor
          y crear nuevos registros basados en los datos del formulario
         */
        Horario::where('doctor_id', $doctor->id)->delete();
        for ($i = 0; $i < count($request->available_time_from); $i++) {
            Horario::create([
                'doctor_id' => $doctor->id,
                'hora_inicio' => $request->available_time_from[$i],
                'hora_fin' => $request->available_time_to[$i],
            ]);
        }

        return redirect()->route('doctores.index')->with('success', 'Doctor actualizado exitosamente');
    }

    // eliminar un doctor
    public function eliminar($id)
    {
        // buscar el doctor por ID y eliminarlo
        $doctor = Doctores::findOrFail($id);
        $doctor->delete();
        return redirect()->route('doctores.index')->with('success', 'Doctor eliminado exitosamente');
    }

    // asignar o quitar rol de admin a un doctor
    public function hacerAdmin(Request $request, $id)
    {
        $doctor = Doctores::findOrFail($id);
        $roleAdmin = Role::whereRaw('LOWER(nombre) = ?', ['admin'])->first();

        if ($roleAdmin) {
            // si is_admin está marcado en la solicitud, asignar el rol de admin
            if ($request->is_admin) {
                if (!$doctor->roles->contains($roleAdmin->id)) {
                    $doctor->roles()->attach($roleAdmin->id);
                }
            } else {
                // si is_admin no está marcado, quitar el rol de admin
                if ($doctor->roles->contains($roleAdmin->id)) {
                    $doctor->roles()->detach($roleAdmin->id);
                }
            }
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Rol de administrador no encontrado.']);
    }
}
