<?php

use App\Models\Evento;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnlacesController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CarpetasController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\LogController;

//.........................................................................................................
// --------------------------------------------------------------------------------------------------------
// Rutas para el panel de admin
// --------------------------------------------------------------------------------------------------------
//.........................................................................................................

Route::middleware(['auth', 'can:isAdmin'])->prefix('admin')->group(function () {

    // Admin
    //Route::get('/', [AdminController::class, 'index'])->name('crm.admin.home.home');
    Route::get('/', [AdminController::class, 'datos'])->name('crm.admin.home.home');


    // Administradores
    Route::get('/administradores', [AdministradorController::class, 'index'])->name('crm.admin.admin.admin');
    Route::get('/administradores/nuevo', [AdministradorController::class, 'create'])->name('crm.admin.admin.nuevo');
    Route::post('/administradores', [AdministradorController::class, 'store'])->name('crm.admin.admin.store');
    Route::get('/administradores/{id}/editar', [AdministradorController::class, 'edit'])->name('crm.admin.admin.edit');
    Route::put('/administradores/{id}', [AdministradorController::class, 'update'])->name('crm.admin.admin.update');
    Route::delete('/administradores/{id}', [AdministradorController::class, 'destroy'])->name('crm.admin.admin.destroy');

    // Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('crm.admin.usuarios.usuarios');
    Route::get('/usuarios/nuevo', [UsuarioController::class, 'create'])->name('crm.admin.usuarios.nuevo');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('crm.admin.usuarios.store');
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit'])->name('crm.admin.usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('crm.admin.usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('crm.admin.usuarios.destroy');

    // Enlaces
    Route::get('/enlaces', [EnlacesController::class, 'index'])->name('crm.admin.enlaces.enlaces');
    Route::get('/enlaces/nuevo', [EnlacesController::class, 'create'])->name('crm.admin.enlaces.nuevo');
    Route::post('/enlaces', [EnlacesController::class, 'store'])->name('crm.admin.enlaces.store');
    Route::get('/enlaces/{id}/editar', [EnlacesController::class, 'edit'])->name('crm.admin.enlaces.edit');
    Route::put('/enlaces/{id}', [EnlacesController::class, 'update'])->name('crm.admin.enlaces.update');
    Route::delete('/enlaces/{id}', [EnlacesController::class, 'destroy'])->name('crm.admin.enlaces.destroy');

    // Documentos
    Route::get('/documentos', [DocumentosController::class, 'index'])->name('crm.admin.documentos.documentos');
    Route::get('/documentos/nuevo', [DocumentosController::class, 'create'])->name('crm.admin.documentos.nuevo');
    Route::post('/documentos', [DocumentosController::class, 'store'])->name('crm.admin.documentos.store');
    Route::get('/documentos/{id}/editar', [DocumentosController::class, 'edit'])->name('crm.admin.documentos.edit');
    Route::put('/documentos/{id}', [DocumentosController::class, 'update'])->name('crm.admin.documentos.update');
    Route::delete('/documentos/{id}', [DocumentosController::class, 'destroy'])->name('crm.admin.documentos.destroy');

    // Carpetas
    Route::get('/carpetas', [CarpetasController::class, 'index'])->name('crm.admin.carpetas.carpetas');
    Route::get('/carpetas/nuevo', [CarpetasController::class, 'create'])->name('crm.admin.carpetas.nuevo');
    Route::post('/carpetas', [CarpetasController::class, 'store'])->name('crm.admin.carpetas.store');
    Route::get('/carpetas/{id}/editar', [CarpetasController::class, 'edit'])->name('crm.admin.carpetas.edit');
    Route::put('/carpetas/{id}', [CarpetasController::class, 'update'])->name('crm.admin.carpetas.update');
    Route::delete('/carpetas/{id}', [CarpetasController::class, 'destroy'])->name('crm.admin.carpetas.destroy');
});
