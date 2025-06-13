<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enlace;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EnlacesController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->permisos == 0) {
            // Admin: obtiene todos los enlaces paginados
            $enlaces = Enlace::paginate(5);
            $conteoEnlaces = Enlace::count();
            $usuarios = User::all();
            return view('crm.admin.enlaces.enlaces', compact('enlaces', 'usuarios', 'conteoEnlaces'));
        } else {
            // Usuario: obtiene solo sus enlaces paginados
            //$enlaces = Enlace::where('id_users', $user->id_users)->paginate(5);
            $enlaces = Enlace::paginate(5);
            $conteoEnlaces = Enlace::count();
            $usuario = $user;
            return view('crm.user.enlaces.enlaces', compact('enlaces', 'usuario', 'conteoEnlaces'));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $enlaces = Enlace::All();
        $usuarios = User::all();

        // Admin puede crear cualquier enlace para cualquier usuario
        if ($user->permisos == 0) {
            $usuarios = User::all();
            return view('crm.admin.enlaces.nuevo', compact('enlaces', 'usuarios'));
        }

        // Usuario solo puede crear sus propios enlaces
        if ($user->permisos == 1) {
            $usuario = $user;
            return view('crm.user.enlaces.nuevo', compact('enlaces', 'usuario'));
        }

        // Si no es ni admin ni dueño, se deniega el acceso
        abort(403, 'No tienes permiso para crear carpetas.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validar los datos recibidos del formulario (sin fecha_creacion)
        $request->validate([
            'nombre' => 'required|string|max:100',
            'url' => 'required|url|max:200',
            'fecha_fin' => 'nullable|date', // mejor que string, es fecha o nulo
        ]);

        // Crear un nuevo enlace asignando fecha_creacion automáticamente
        $enlace = new Enlace();
        $enlace->id_users = $user->id_users; // asignar el usuario autenticado
        $enlace->nombre = $request->nombre;
        $enlace->url = $request->url;
        $enlace->fecha_creacion = Carbon::now(); // fecha actual
        $enlace->fecha_fin = $request->fecha_fin;
        $enlace->save();

        // Redirigir
        $ruta = $user->permisos == 0
            ? 'crm.admin.enlaces.enlaces'
            : 'crm.user.enlaces.enlaces';

        return redirect()->route($ruta)->with('success', 'Enlace creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $usuarios = User::all();

        $enlace = Enlace::findOrFail($id);
        $enlaces = Enlace::all();

        // Redirigir
        $vista = $user->permisos == 0
            ? 'crm.admin.enlaces.edit'
            : 'crm.user.enlaces.edit';

        return view($vista, compact('enlace', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $enlace = Enlace::findOrFail($id);
        $user = Auth::user();

        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'url' => 'required|url|max:200',
            'fecha_creacion' => 'required|date',
            'fecha_fin' => 'nullable|date',
        ]);

        // Actualizar campos
        $enlace->nombre = $request->nombre;
        $enlace->url = $request->url;
        $enlace->fecha_creacion = $request->fecha_creacion;
        $enlace->fecha_fin = $request->fecha_fin;
        $enlace->save();

        // Redirigir
        $ruta = $user->permisos == 0
            ? 'crm.admin.enlaces.enlaces'
            : 'crm.user.enlaces.enlaces';

        return redirect()->route($ruta)->with('success', 'Enlace actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $enlace = Enlace::findOrFail($id);
        $user = Auth::user();

        $enlace->delete();


        // Redirigir
        $ruta = $user->permisos == 0
            ? 'crm.admin.enlaces.enlaces'
            : 'crm.user.enlaces.enlaces';

        return redirect()->route($ruta)->with('success', 'Enlace eliminado correctamente.');
    }
}
