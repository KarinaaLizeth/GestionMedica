<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctoresController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\SecretariasController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\FullCalendarController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    
    Route::get('/', [FullCalendarController::class, 'index'])->name('index');
});

require __DIR__.'/auth.php';
