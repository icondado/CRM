<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;

class AdminController extends Controller
{
    
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('crm.admin.home.home');
    }
    
    /**
     * Summary of datos
     * Manda la cantidad de usuarios con permiso 0 (admin)
     * Manda la cantidad de usuarios con permiso 1 (Usuarios)
     * Manda los últimos Logs con descripción con palabra=sesión
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function datos()
    {
        $conteoPermiso1 = User::where('permisos', 1)->count();
        $conteoPermiso0 = User::where('permisos', 0)->count();

        // Buscar logs con "sesión" en la descripción (insensible a mayúsculas/minúsculas)
        $logs = Log::where('descripcion', 'LIKE', '%sesión%')
                    ->orderBy('fecha', 'desc')
                    ->take(5)
                    ->get();

        return view('crm.admin.home.home', compact('conteoPermiso1', 'conteoPermiso0', 'logs'));
    }

}
