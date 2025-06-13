<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index()
    {
        // Obtiene logs ordenados por fecha descendente, 5 por página
        $logs = Log::orderBy('fecha', 'desc')->paginate(5);
        $usuarios = User::All();

        return view('crm.admin.home.logs', compact('logs', 'usuarios'));
    }

    public function insertarLog(Request $request)
    {
        // Validar datos básicos que vengan por request
        $request->validate([
            'tabla_afectada' => 'required|string',
            'accion' => 'required|string',
            'registro_id' => 'required|integer',
            'descripcion' => 'nullable|string',
        ]);

        // Crear log
        $log = Log::create([
            'id_users' => Auth::id(), // usuario autenticado
            'tabla_afectada' => $request->tabla_afectada,
            'accion' => $request->accion,
            'registro_id' => $request->registro_id,
            'descripcion' => $request->descripcion ?? '',
            'fecha' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Log creado con éxito', 'log' => $log], 201);
    }

    // Crear un método de prueba
    public function pruebaLog()
    {
        Log::create([
            'id_users' => Auth::id(),
            'tabla_afectada' => 'test',
            'accion' => 'test_insert',
            'registro_id' => 0,
            'descripcion' => 'Log de prueba insertado manualmente',
            'fecha' => Carbon::now(),
        ]);

        return 'Log insertado con éxito';
    }

}
