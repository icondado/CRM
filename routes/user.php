<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnlacesController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CarpetasController;
use App\Http\Controllers\DocumentosController;

//.........................................................................................................
// --------------------------------------------------------------------------------------------------------
// Rutas para el panel de usuario
// --------------------------------------------------------------------------------------------------------
//.........................................................................................................

Route::middleware(['auth', 'can:isUser'])->prefix('usuario')->group(function () {

    // Panel de inicio
    Route::get('/', [UserController::class, 'index'])->name('crm.user.home.home');

    // Carpetas
    Route::get('/carpetas', [CarpetasController::class, 'index'])->name('crm.user.carpetas.carpetas');
    Route::get('/carpetas/nuevo', [CarpetasController::class, 'create'])->name('crm.user.carpetas.nuevo');
    Route::post('/carpetas', [CarpetasController::class, 'store'])->name('crm.user.carpetas.store');
    Route::get('/carpetas/{id}/editar', [CarpetasController::class, 'edit'])->name('crm.user.carpetas.edit');
    Route::put('/carpetas/{id}', [CarpetasController::class, 'update'])->name('crm.user.carpetas.update');
    Route::delete('/carpetas/{id}', [CarpetasController::class, 'destroy'])->name('crm.user.carpetas.destroy');

    // Documentos
    Route::get('/documentos', [DocumentosController::class, 'index'])->name('crm.user.documentos.documentos');
    Route::get('/documentos/nuevo', [DocumentosController::class, 'create'])->name('crm.user.documentos.nuevo');
    Route::post('/documentos', [DocumentosController::class, 'store'])->name('crm.user.documentos.store');
    Route::get('/documentos/{id}/editar', [DocumentosController::class, 'edit'])->name('crm.user.documentos.edit');
    Route::put('/documentos/{id}', [DocumentosController::class, 'update'])->name('crm.user.documentos.update');
    Route::delete('/documentos/{id}', [DocumentosController::class, 'destroy'])->name('crm.user.documentos.destroy');

    // Perfil
    Route::get('/perfil', [UsuarioController::class, 'index'])->name('crm.user.perfil.perfil');
    Route::get('/perfil/{id}/editar', [UsuarioController::class, 'edit'])->name('crm.user.perfil.edit');
    Route::put('/perfil/{id}', [UsuarioController::class, 'update'])->name('crm.user.perfil.update');

    // Enlaces
    Route::get('/enlaces', [EnlacesController::class, 'index'])->name('crm.user.enlaces.enlaces');
    Route::get('/enlaces/nuevo', [EnlacesController::class, 'create'])->name('crm.user.enlaces.nuevo');
    Route::post('/enlaces', [EnlacesController::class, 'store'])->name('crm.user.enlaces.store');
    Route::get('/enlaces/{id}/editar', [EnlacesController::class, 'edit'])->name('crm.user.enlaces.edit');
    Route::put('/enlaces/{id}', [EnlacesController::class, 'update'])->name('crm.user.enlaces.update');
    Route::delete('/enlaces/{id}', [EnlacesController::class, 'destroy'])->name('crm.user.enlaces.destroy');
});
