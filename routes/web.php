<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctoresController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ServiciosController;

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
    Route::get('/doctores/crear', [DoctoresController::class, 'create'])->name('doctores.create');
    Route::post('/doctores', [DoctoresController::class, 'store'])->name('doctores.store');
    Route::get('/doctores/{doctor}/editar', [DoctoresController::class, 'edit'])->name('doctores.edit');
    Route::put('/doctores/{doctor}', [DoctoresController::class, 'update'])->name('doctores.update');

    // Rutas para Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/crear', [PacientesController::class, 'create'])->name('pacientes.create');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
    Route::get('/pacientes/{paciente}/editar', [PacientesController::class, 'edit'])->name('pacientes.edit');
    Route::put('/pacientes/{paciente}', [PacientesController::class, 'update'])->name('pacientes.update');

    // Rutas para servicios
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear', [ServiciosController::class, 'create'])->name('servicios.create');
    Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{servicio}/editar', [ServiciosController::class, 'edit'])->name('servicios.edit');
    Route::put('/servicios/{servicio}', [ServiciosController::class, 'update'])->name('servicios.update');

});

require __DIR__.'/auth.php';
