<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\Log;

class LogSuccessfulLogout
{
    public function handle(Logout $event)
    {
        $user = $event->user;

        // Puede ser null si no hay usuario (por ejemplo, logout manual sin sesión)
        if (!$user) {
            return;
        }

        Log::create([
            'id_users' => $user->id_users,
            'tabla_afectada' => 'users',
            'accion' => 'logout',
            'registro_id' => $user->id_users,
            'descripcion' =>  'El usuario ' . $user->nombre . ' ' . $user->apellidos . ' cerró sesión.',
            'fecha' => now(),
        ]);
    }
}
