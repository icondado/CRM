<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Log;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;

        Log::create([
            'id_users' => $user->id_users,
            'tabla_afectada' => 'users',
            'accion' => 'login',
            'registro_id' => $user->id_users,
            'descripcion' => 'El usuario ' . $user->nombre . ' ' . $user->apellidos . ' inició sesión.',
            'fecha' => now(),
        ]);
    }
}
