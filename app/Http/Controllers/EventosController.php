<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventosController extends Controller
{

    /**
     * Listar eventos y usuarios para el calendario
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();

        // Usuarios
        $usuarios = User::select('id_users', 'nombre', 'apellidos')->get();

        // Eventos según permiso
        if ($user->permisos == 0) {
            // Admin ve todos los eventos
            $eventos = Evento::with('usuario')->get();
        } else {
            // Usuario ve sus propios eventos + eventos creados por administradores
            $adminIds = User::where('permisos', 0)->pluck('id_users');

            $eventos = Evento::with('usuario')
                ->whereIn('id_users', $adminIds->push($user->id_users))
                ->get();
        }

        $eventos_formateados = $eventos->map(function ($evento) {
            return [
                'id' => $evento->id_evento,
                'title' => $evento->titulo_evento,
                'start' => $evento->fecha_inicio_evento . 'T' . $evento->hora_inicio_evento,
                'end' => $evento->fecha_fin_evento . 'T' . $evento->hora_fin_evento,
                'id_users' => $evento->id_users,
                'descripcion_evento' => $evento->descripcion_evento,
                'hora_inicio_evento' => $evento->hora_inicio_evento,
                'hora_fin_evento' => $evento->hora_fin_evento,
                'usuario_nombre' => $evento->usuario ? $evento->usuario->nombre . ' ' . $evento->usuario->apellidos : '',
            ];
        });

        return response()->json([
            'eventos' => $eventos_formateados,
            'usuarios' => $usuarios,
        ]);
    }


    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'titulo_evento' => 'required|string|max:50',
            'descripcion_evento' => 'required|string|max:500',
            'fecha_inicio_evento' => 'required|date',
            'hora_inicio_evento' => 'required|date_format:H:i',
            'fecha_fin_evento' => 'required|date|after_or_equal:fecha_inicio_evento',
            'hora_fin_evento' => 'required|date_format:H:i',
        ]);

        $hora_inicio = $request->hora_inicio_evento . ':00'; // Añadir segundos
        $hora_fin = $request->hora_fin_evento . ':00';

        $fechaHoraInicio = $request->fecha_inicio_evento . ' ' . $hora_inicio;
        $fechaHoraFin = $request->fecha_fin_evento . ' ' . $hora_fin;

        if (strtotime($fechaHoraFin) < strtotime($fechaHoraInicio)) {
            return response()->json([
                'message' => 'La fecha y hora de fin debe ser igual o posterior a la de inicio.'
            ], 422);
        }

        if ($user->permisos == 0) {
            $request->validate([
                'id_users' => 'required|exists:users,id_users',
            ]);
            $id_users = $request->id_users;
        } else {
            $id_users = $user->id_users;
        }

        $evento = Evento::create([
            'titulo_evento' => $request->titulo_evento,
            'descripcion_evento' => $request->descripcion_evento,
            'fecha_inicio_evento' => $request->fecha_inicio_evento,
            'hora_inicio_evento' => $hora_inicio,
            'fecha_fin_evento' => $request->fecha_fin_evento,
            'hora_fin_evento' => $hora_fin,
            'id_users' => $id_users,
        ]);

        return response()->json($evento, 201);
    }



    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // Buscar el evento, si no existe devuelve 404
        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json(['message' => 'Evento no encontrado.'], 404);
        }

        $request->validate([
            'titulo_evento' => 'required|string|max:50',
            'descripcion_evento' => 'required|string|max:500',
            'fecha_inicio_evento' => 'required|date',
            'hora_inicio_evento' => 'required|date_format:H:i',
            'fecha_fin_evento' => 'required|date|after_or_equal:fecha_inicio_evento',
            'hora_fin_evento' => 'required|date_format:H:i',
        ]);

        // Asegurar segundos
        $hora_inicio = $request->hora_inicio_evento . ':00';
        $hora_fin = $request->hora_fin_evento . ':00';

        // Validación de coherencia de fechas
        $fechaHoraInicio = $request->fecha_inicio_evento . ' ' . $hora_inicio;
        $fechaHoraFin = $request->fecha_fin_evento . ' ' . $hora_fin;

        if (strtotime($fechaHoraFin) < strtotime($fechaHoraInicio)) {
            return response()->json([
                'message' => 'La fecha y hora de fin debe ser igual o posterior a la de inicio.'
            ], 422);
        }


        // Validación de usuario si es admin
        if ($user->permisos == 0) {
            $request->validate([
                'id_users' => 'required|exists:users,id_users',
            ]);
            $id_users = $request->id_users;
        } else {
            $id_users = $user->id_users;
        }

        // Actualizar los datos del evento
        $evento->update([
            'titulo_evento' => $request->titulo_evento,
            'descripcion_evento' => $request->descripcion_evento,
            'fecha_inicio_evento' => $request->fecha_inicio_evento,
            'hora_inicio_evento' => $hora_inicio,
            'fecha_fin_evento' => $request->fecha_fin_evento,
            'hora_fin_evento' => $hora_fin,
            'id_users' => $id_users,
        ]);

        return response()->json($evento, 200);
    }


    /**
     * Summary of destroy
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();
        return response()->json(['message' => 'Evento eliminado correctamente'], 200);
    }
}
