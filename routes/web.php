<?php

use App\Models\Evento;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\CarpetasController;
use App\Http\Controllers\AdministradorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::middleware(['auth'])->group(function () {
    // Ruta para obtener carpetas por usuario
    Route::get('/carpetas-por-usuario/{id_user}', [CarpetasController::class, 'carpetasPorUsuario']);
    // Ruta para obtener los eventos
    Route::get('/eventos', function () {
        return Evento::all();
    });
});

//Log
Route::post('/logs/insertar', [LogController::class, 'insertarLog'])->middleware('auth');
Route::get('/log/prueba', [LogController::class, 'pruebaLog'])->middleware('auth');
Route::get('/admin/logs', [LogController::class, 'index'])->middleware('auth');

// Rutas del calendario
Route::get('/eventos', [EventosController::class, 'index']);
Route::post('/eventos', [EventosController::class, 'store']);
Route::put('/eventos/{id}', [EventosController::class, 'update']);
Route::delete('/eventos/{id}', [EventosController::class, 'destroy']);


require __DIR__ . '/auth.php';
