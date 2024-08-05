<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctoresController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\SecretariasController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\HistorialController;
use App\Http\Middleware\Roles;


// Ruta para la página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/logout', function () {
    return view('welcome');
})->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para Doctores
    Route::get('/doctores', [DoctoresController::class, 'index'])->name('doctores.index');
    Route::get('/doctores/crear', [DoctoresController::class, 'crear'])->name('doctores.crear');
    Route::post('/doctores', [DoctoresController::class, 'store'])->name('doctores.store');
    Route::get('/doctores/{doctor}/editar', [DoctoresController::class, 'editar'])->name('doctores.editar');
    Route::put('/doctores/{doctor}', [DoctoresController::class, 'actualizar'])->name('doctores.actualizar');
    Route::delete('/doctores/{doctor}', [DoctoresController::class, 'eliminar'])->name('doctores.eliminar');


    //rutas para doctoresadmin
    Route::get('/doctores/lista', [DoctoresController::class, 'lista'])->name('doctores.lista');
    Route::post('/doctores/{id}/admin', [DoctoresController::class, 'hacerAdmin'])->name('doctores.admin');


    // Rutas para Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/crear', [PacientesController::class, 'crear'])->name('pacientes.crear');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
    Route::get('/pacientes/{paciente}/editar', [PacientesController::class, 'editar'])->name('pacientes.editar');
    Route::put('/pacientes/{paciente}', [PacientesController::class, 'actualizar'])->name('pacientes.actualizar');
    Route::delete('/pacientes/{paciente}', [PacientesController::class, 'eliminar'])->name('pacientes.eliminar');

    // Rutas para servicios
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear', [ServiciosController::class, 'crear'])->name('servicios.crear');
    Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{servicio}/editar', [ServiciosController::class, 'editar'])->name('servicios.editar');
    Route::put('/servicios/{servicio}', [ServiciosController::class, 'actualizar'])->name('servicios.actualizar');
    Route::delete('/servicios/{servicio}', [ServiciosController::class, 'eliminar'])->name('servicios.eliminar');

    // Rutas para secretarias
    Route::get('/secretarias', [SecretariasController::class, 'index'])->name('secretarias.index');
    Route::get('/secretarias/crear', [SecretariasController::class, 'crear'])->name('secretarias.crear');
    Route::post('/secretarias', [SecretariasController::class, 'store'])->name('secretarias.store');
    Route::get('/secretarias/{secretaria}/editar', [SecretariasController::class, 'editar'])->name('secretarias.editar');
    Route::put('/secretarias/{secretaria}', [SecretariasController::class, 'actualizar'])->name('secretarias.actualizar');
    Route::delete('/secretarias/{secretaria}', [SecretariasController::class, 'eliminar'])->name('secretarias.eliminar');

    //rutas para citas
    Route::get('/citas', [CitasController::class, 'index'])->name('citas.index');
    Route::get('/citas/crear', [CitasController::class, 'crear'])->name('citas.crear');
    Route::post('/citas', [CitasController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar', [CitasController::class, 'editar'])->name('citas.editar');
    Route::put('/citas/{id}', [CitasController::class, 'actualizar'])->name('citas.actualizar');
    Route::delete('/citas/{id}', [CitasController::class, 'eliminar'])->name('citas.eliminar');
    Route::get('/citas/lista', [CitasController::class, 'lista'])->name('citas.lista');
    Route::get('/citas/{id}/cambiar-estado/{estado}', [CitasController::class, 'cambiarEstado'])->name('citas.cambiarEstado');
    Route::get('/horarios-disponibles', [CitasController::class, 'getHorariosDisponibles']);
    Route::get('/citas-eventos', [CitasController::class, 'getCitasEventos']);
    Route::get('/citas-dia', [CitasController::class, 'getCitasPorDia']);


    //rutas consultas
    Route::get('/consultas', [ConsultasController::class, 'index'])->name('consultas.index');
    Route::get('/consultas/crear', [ConsultasController::class, 'crear'])->name('consultas.crear');
    Route::post('/consultas', [ConsultasController::class, 'store'])->name('consultas.store');
    Route::get('/consultas/{id}/editar', [ConsultasController::class, 'editar'])->name('consultas.editar');
    Route::put('/consultas/{id}', [ConsultasController::class, 'update'])->name('consultas.update');
    Route::get('/consultas/crear/{paciente}', [ConsultasController::class, 'crearDesdePaciente'])->name('consultas.crear.paciente');
    Route::get('/lista-consultas', [ConsultasController::class, 'listaConsultas'])->name('consultas.lista');
    Route::delete('/consultas/servicios/{id}', [ConsultasController::class, 'eliminarServicio'])->name('consultas.servicios.eliminar');
    Route::get('/consultas/{id}', [ConsultasController::class, 'ver'])->name('consultas.ver');

    // Rutas para roles
    Route::get('/rol', [RolController::class, 'index'])->name('rol.index');
    Route::get('/rol/crear', [RolController::class, 'crear'])->name('rol.crear');
    Route::post('/rol', [RolController::class, 'store'])->name('rol.store');
    Route::get('/role/{id}/editar', [RolController::class, 'editar'])->name('rol.editar');
    Route::put('/rol/{id}', [RolController::class, 'actualizar'])->name('rol.actualizar');
    Route::delete('/rol/{id}', [RolController::class, 'eliminar'])->name('rol.eliminar');

    //rutas para ventas
    Route::get('/ventas/crear', [VentasController::class, 'crear'])->name('ventas.crear');
    Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');
    Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{id}/ver', [VentasController::class, 'ver'])->name('ventas.ver');

}); */

Route::middleware([Roles::class . ':doctor'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para Doctores
    Route::get('/doctores', [DoctoresController::class, 'index'])->name('doctores.index');
    Route::get('/doctores/crear', [DoctoresController::class, 'crear'])->name('doctores.crear');
    Route::post('/doctores', [DoctoresController::class, 'store'])->name('doctores.store');
    Route::get('/doctores/{doctor}/editar', [DoctoresController::class, 'editar'])->name('doctores.editar');
    Route::put('/doctores/{doctor}', [DoctoresController::class, 'actualizar'])->name('doctores.actualizar');
    Route::delete('/doctores/{doctor}', [DoctoresController::class, 'eliminar'])->name('doctores.eliminar');


    // Rutas para Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/crear', [PacientesController::class, 'crear'])->name('pacientes.crear');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
    Route::get('/pacientes/{paciente}/editar', [PacientesController::class, 'editar'])->name('pacientes.editar');
    Route::put('/pacientes/{paciente}', [PacientesController::class, 'actualizar'])->name('pacientes.actualizar');
    Route::delete('/pacientes/{paciente}', [PacientesController::class, 'eliminar'])->name('pacientes.eliminar');

    // Rutas para servicios
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear', [ServiciosController::class, 'crear'])->name('servicios.crear');
    Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{servicio}/editar', [ServiciosController::class, 'editar'])->name('servicios.editar');
    Route::put('/servicios/{servicio}', [ServiciosController::class, 'actualizar'])->name('servicios.actualizar');
    Route::delete('/servicios/{servicio}', [ServiciosController::class, 'eliminar'])->name('servicios.eliminar');
    Route::post('/servicios/{id}/reducir/{cantidad}', [ServiciosController::class, 'reducirCantidad'])->name('servicios.reducir');

    // Rutas para secretarias
    Route::get('/secretarias', [SecretariasController::class, 'index'])->name('secretarias.index');
    Route::get('/secretarias/crear', [SecretariasController::class, 'crear'])->name('secretarias.crear');
    Route::post('/secretarias', [SecretariasController::class, 'store'])->name('secretarias.store');
    Route::get('/secretarias/{secretaria}/editar', [SecretariasController::class, 'editar'])->name('secretarias.editar');
    Route::put('/secretarias/{secretaria}', [SecretariasController::class, 'actualizar'])->name('secretarias.actualizar');
    Route::delete('/secretarias/{secretaria}', [SecretariasController::class, 'eliminar'])->name('secretarias.eliminar');

    //rutas para citas
    Route::get('/citas', [CitasController::class, 'index'])->name('citas.index');
    Route::get('/citas/crear', [CitasController::class, 'crear'])->name('citas.crear');
    Route::post('/citas', [CitasController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar', [CitasController::class, 'editar'])->name('citas.editar');
    Route::put('/citas/{id}', [CitasController::class, 'actualizar'])->name('citas.actualizar');
    Route::delete('/citas/{id}', [CitasController::class, 'eliminar'])->name('citas.eliminar');
    Route::get('/citas/lista', [CitasController::class, 'lista'])->name('citas.lista');
    Route::get('/citas/{id}/cambiar-estado/{estado}', [CitasController::class, 'cambiarEstado'])->name('citas.cambiarEstado');
    Route::get('/horarios-disponibles', [CitasController::class, 'getHorariosDisponibles']);
    Route::get('/citas-eventos', [CitasController::class, 'getCitasEventos']);
    Route::get('/citas-dia', [CitasController::class, 'getCitasPorDia']);


    //rutas consultas
    Route::get('/consultas', [ConsultasController::class, 'index'])->name('consultas.index');
    Route::get('/consultas/crear', [ConsultasController::class, 'crear'])->name('consultas.crear');
    Route::post('/consultas', [ConsultasController::class, 'store'])->name('consultas.store');
    Route::get('/consultas/{id}/editar', [ConsultasController::class, 'editar'])->name('consultas.editar');
    Route::put('/consultas/{id}', [ConsultasController::class, 'update'])->name('consultas.update');
    Route::get('/consultas/crear/{paciente}', [ConsultasController::class, 'crearDesdePaciente'])->name('consultas.crear.paciente');
    Route::get('/lista-consultas', [ConsultasController::class, 'listaConsultas'])->name('consultas.lista');
    Route::delete('/consultas/servicios/{id}', [ConsultasController::class, 'eliminarServicio'])->name('consultas.servicios.eliminar');
    Route::get('/consultas/{id}', [ConsultasController::class, 'ver'])->name('consultas.ver');

    //rutas para ventas
    Route::get('/ventas/crear', [VentasController::class, 'crear'])->name('ventas.crear');
    Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');
    Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{id}/ver', [VentasController::class, 'ver'])->name('ventas.ver');

    Route::get('/logout', function () {
        return view('welcome');
    })->name('logout');
});

Route::middleware([Roles::class . ':secretaria'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para Doctores
    Route::get('/doctores', [DoctoresController::class, 'index'])->name('doctores.index');
    Route::get('/doctores/crear', [DoctoresController::class, 'crear'])->name('doctores.crear');
    Route::post('/doctores', [DoctoresController::class, 'store'])->name('doctores.store');
    Route::get('/doctores/{doctor}/editar', [DoctoresController::class, 'editar'])->name('doctores.editar');
    Route::put('/doctores/{doctor}', [DoctoresController::class, 'actualizar'])->name('doctores.actualizar');
    Route::delete('/doctores/{doctor}', [DoctoresController::class, 'eliminar'])->name('doctores.eliminar');


    // Rutas para Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/crear', [PacientesController::class, 'crear'])->name('pacientes.crear');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
    Route::get('/pacientes/{paciente}/editar', [PacientesController::class, 'editar'])->name('pacientes.editar');
    Route::put('/pacientes/{paciente}', [PacientesController::class, 'actualizar'])->name('pacientes.actualizar');
    Route::delete('/pacientes/{paciente}', [PacientesController::class, 'eliminar'])->name('pacientes.eliminar');

    // Rutas para servicios
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear', [ServiciosController::class, 'crear'])->name('servicios.crear');
    Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{servicio}/editar', [ServiciosController::class, 'editar'])->name('servicios.editar');
    Route::put('/servicios/{servicio}', [ServiciosController::class, 'actualizar'])->name('servicios.actualizar');
    Route::delete('/servicios/{servicio}', [ServiciosController::class, 'eliminar'])->name('servicios.eliminar');
    Route::post('/servicios/{id}/reducir/{cantidad}', [ServiciosController::class, 'reducirCantidad'])->name('servicios.reducir');
    // Rutas para secretarias
    Route::get('/secretarias', [SecretariasController::class, 'index'])->name('secretarias.index');
    Route::get('/secretarias/crear', [SecretariasController::class, 'crear'])->name('secretarias.crear');
    Route::post('/secretarias', [SecretariasController::class, 'store'])->name('secretarias.store');
    Route::get('/secretarias/{secretaria}/editar', [SecretariasController::class, 'editar'])->name('secretarias.editar');
    Route::put('/secretarias/{secretaria}', [SecretariasController::class, 'actualizar'])->name('secretarias.actualizar');
    Route::delete('/secretarias/{secretaria}', [SecretariasController::class, 'eliminar'])->name('secretarias.eliminar');

    //rutas para citas
    Route::get('/citas', [CitasController::class, 'index'])->name('citas.index');
    Route::get('/citas/crear', [CitasController::class, 'crear'])->name('citas.crear');
    Route::post('/citas', [CitasController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar', [CitasController::class, 'editar'])->name('citas.editar');
    Route::put('/citas/{id}', [CitasController::class, 'actualizar'])->name('citas.actualizar');
    Route::delete('/citas/{id}', [CitasController::class, 'eliminar'])->name('citas.eliminar');
    Route::get('/citas/lista', [CitasController::class, 'lista'])->name('citas.lista');
    Route::get('/citas/{id}/cambiar-estado/{estado}', [CitasController::class, 'cambiarEstado'])->name('citas.cambiarEstado');
    Route::get('/horarios-disponibles', [CitasController::class, 'getHorariosDisponibles']);
    Route::get('/citas-eventos', [CitasController::class, 'getCitasEventos']);
    Route::get('/citas-dia', [CitasController::class, 'getCitasPorDia']);


    //rutas consultas
    Route::get('/consultas', [ConsultasController::class, 'index'])->name('consultas.index');
    Route::get('/consultas/crear', [ConsultasController::class, 'crear'])->name('consultas.crear');
    Route::post('/consultas', [ConsultasController::class, 'store'])->name('consultas.store');
    Route::get('/consultas/{id}/editar', [ConsultasController::class, 'editar'])->name('consultas.editar');
    Route::put('/consultas/{id}', [ConsultasController::class, 'update'])->name('consultas.update');
    Route::get('/consultas/crear/{paciente}', [ConsultasController::class, 'crearDesdePaciente'])->name('consultas.crear.paciente');
    Route::get('/lista-consultas', [ConsultasController::class, 'listaConsultas'])->name('consultas.lista');
    Route::delete('/consultas/servicios/{id}', [ConsultasController::class, 'eliminarServicio'])->name('consultas.servicios.eliminar');
    Route::get('/consultas/{id}', [ConsultasController::class, 'ver'])->name('consultas.ver');

    //rutas para ventas
    Route::get('/ventas/crear', [VentasController::class, 'crear'])->name('ventas.crear');
    Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');
    Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{id}/ver', [VentasController::class, 'ver'])->name('ventas.ver');

    Route::get('/logout', function () {
        return view('welcome');
    })->name('logout');
});

Route::middleware([Roles::class . ':admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para Doctores
    Route::get('/doctores', [DoctoresController::class, 'index'])->name('doctores.index');
    Route::get('/doctores/crear', [DoctoresController::class, 'crear'])->name('doctores.crear');
    Route::post('/doctores', [DoctoresController::class, 'store'])->name('doctores.store');
    Route::get('/doctores/{doctor}/editar', [DoctoresController::class, 'editar'])->name('doctores.editar');
    Route::put('/doctores/{doctor}', [DoctoresController::class, 'actualizar'])->name('doctores.actualizar');
    Route::delete('/doctores/{doctor}', [DoctoresController::class, 'eliminar'])->name('doctores.eliminar');


    //rutas para doctoresadmin
    Route::get('/doctores/lista', [DoctoresController::class, 'lista'])->name('doctores.lista');
    Route::post('/doctores/{id}/admin', [DoctoresController::class, 'hacerAdmin'])->name('doctores.admin');


    // Rutas para Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/crear', [PacientesController::class, 'crear'])->name('pacientes.crear');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
    Route::get('/pacientes/{paciente}/editar', [PacientesController::class, 'editar'])->name('pacientes.editar');
    Route::put('/pacientes/{paciente}', [PacientesController::class, 'actualizar'])->name('pacientes.actualizar');
    Route::delete('/pacientes/{paciente}', [PacientesController::class, 'eliminar'])->name('pacientes.eliminar');

    // Rutas para servicios
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear', [ServiciosController::class, 'crear'])->name('servicios.crear');
    Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{servicio}/editar', [ServiciosController::class, 'editar'])->name('servicios.editar');
    Route::put('/servicios/{servicio}', [ServiciosController::class, 'actualizar'])->name('servicios.actualizar');
    Route::delete('/servicios/{servicio}', [ServiciosController::class, 'eliminar'])->name('servicios.eliminar');
    Route::post('/servicios/{id}/reducir/{cantidad}', [ServiciosController::class, 'reducirCantidad'])->name('servicios.reducir');
   
    // Rutas para secretarias
    Route::get('/secretarias', [SecretariasController::class, 'index'])->name('secretarias.index');
    Route::get('/secretarias/crear', [SecretariasController::class, 'crear'])->name('secretarias.crear');
    Route::post('/secretarias', [SecretariasController::class, 'store'])->name('secretarias.store');
    Route::get('/secretarias/{secretaria}/editar', [SecretariasController::class, 'editar'])->name('secretarias.editar');
    Route::put('/secretarias/{secretaria}', [SecretariasController::class, 'actualizar'])->name('secretarias.actualizar');
    Route::delete('/secretarias/{secretaria}', [SecretariasController::class, 'eliminar'])->name('secretarias.eliminar');

    //rutas para citas
    Route::get('/citas', [CitasController::class, 'index'])->name('citas.index');
    Route::get('/citas/crear', [CitasController::class, 'crear'])->name('citas.crear');
    Route::post('/citas', [CitasController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar', [CitasController::class, 'editar'])->name('citas.editar');
    Route::put('/citas/{id}', [CitasController::class, 'actualizar'])->name('citas.actualizar');
    Route::delete('/citas/{id}', [CitasController::class, 'eliminar'])->name('citas.eliminar');
    Route::get('/citas/lista', [CitasController::class, 'lista'])->name('citas.lista');
    Route::get('/citas/{id}/cambiar-estado/{estado}', [CitasController::class, 'cambiarEstado'])->name('citas.cambiarEstado');
    Route::get('/horarios-disponibles', [CitasController::class, 'getHorariosDisponibles']);
    Route::get('/citas-eventos', [CitasController::class, 'getCitasEventos']);
    Route::get('/citas-dia', [CitasController::class, 'getCitasPorDia']);
    Route::get('/citas/cambiarEstado/{id}/{estado}', [CitasController::class, 'cambiarEstado'])->name('citas.cambiarEstado');
    Route::post('/citas/{id}/actualizar-fecha', [CitasController::class, 'actualizarFecha']);


    //rutas consultas
    Route::get('/consultas', [ConsultasController::class, 'index'])->name('consultas.index');
    Route::get('/consultas/crear', [ConsultasController::class, 'crear'])->name('consultas.crear');
    Route::post('/consultas', [ConsultasController::class, 'store'])->name('consultas.store');
    Route::get('/consultas/{id}/editar', [ConsultasController::class, 'editar'])->name('consultas.editar');
    Route::put('/consultas/{id}', [ConsultasController::class, 'update'])->name('consultas.update');
    Route::get('/consultas/crear/{paciente}', [ConsultasController::class, 'crearDesdePaciente'])->name('consultas.crear.paciente');
    Route::get('/lista-consultas', [ConsultasController::class, 'listaConsultas'])->name('consultas.lista');
    Route::delete('/consultas/servicios/{id}', [ConsultasController::class, 'eliminarServicio'])->name('consultas.servicios.eliminar');
    Route::get('/consultas/{id}', [ConsultasController::class, 'ver'])->name('consultas.ver');
    Route::post('/consultas/{id}/completar', [ConsultasController::class, 'completar'])->name('consultas.completar');

    // Rutas para roles
    Route::get('/rol', [RolController::class, 'index'])->name('rol.index');
    Route::get('/rol/crear', [RolController::class, 'crear'])->name('rol.crear');
    Route::post('/rol', [RolController::class, 'store'])->name('rol.store');
    Route::get('/role/{id}/editar', [RolController::class, 'editar'])->name('rol.editar');
    Route::put('/rol/{id}', [RolController::class, 'actualizar'])->name('rol.actualizar');
    Route::delete('/rol/{id}', [RolController::class, 'eliminar'])->name('rol.eliminar');

    //rutas para ventas
    Route::get('/ventas/crear', [VentasController::class, 'crear'])->name('ventas.crear');
    Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');
    Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{id}/ver', [VentasController::class, 'ver'])->name('ventas.ver');


    //rutas para historial
    Route::get('/pacientes/{paciente}/historial', [HistorialController::class, 'mostrarHistorial'])->name('pacientes.historial');

    Route::get('/logout', function () {
        return view('welcome');
    })->name('logout');
});
require __DIR__.'/auth.php';
