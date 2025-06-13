<?php

namespace App\Http\Controllers;

use App\Models\Carpeta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarpetasController extends Controller
{

    //---------------------------------------------------------------------------------------------//
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->permisos == 0) {
            // Admin ve todas las carpetas y usuarios
            $carpetas = Carpeta::with('usuario')->paginate(5);
            $conteoCarpetas = Carpeta::count();
            $usuarios = User::all();

            return view('crm.admin.carpetas.carpetas', compact('carpetas', 'usuarios', 'conteoCarpetas'));
        } else {
            // Usuario ve solo sus propias carpetas
            $carpetas = Carpeta::with('usuario')->where('id_users', $user->id_users)->paginate(10);
            $conteoCarpetas = Carpeta::with('usuario')->where('id_users', $user->id_users)->count();
            $usuario = $user;
            return view('crm.user.carpetas.carpetas', compact('carpetas', 'usuario', 'conteoCarpetas'));
        }
    }


    //---------------------------------------------------------------------------------------------//
    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = Auth::user();
        $carpetas = Carpeta::all();
        $usuarios = User::all();

        // Admin puede crear cualquier carpeta para cualquier usuario
        if ($user->permisos == 0) {
            $usuarios = User::all(); // útil si el formulario permite cambiar el usuario
            return view('crm.admin.carpetas.nuevo', compact('carpetas', 'usuarios'));
        }

        // Usuario solo puede editar sus propias carpetas
        if ($user->permisos == 1) {
            $usuario = $user;
            $carpetas = Carpeta::where('id_users', $user->id_users)->get();
            return view('crm.user.carpetas.nuevo', compact('carpetas', 'usuario'));
        }

        // Si no es ni admin ni dueño, se deniega el acceso
        abort(403, 'No tienes permiso para crear carpetas.');
    }


    //---------------------------------------------------------------------------------------------
    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validación del formulario
        $request->validate([
            'nombre_carpeta' => 'nullable|string|max:50',
            'id_users' => 'required|integer|exists:users,id_users',
        ], [
            'nombre_carpeta.string' => 'El nombre de la carpeta debe ser una cadena de texto.',
            'nombre_carpeta.max' => 'El nombre de la carpeta no puede tener más de 50 caracteres.',
            'id_users.required' => 'El ID de usuario es obligatorio.',
            'id_users.integer' => 'El ID de usuario debe ser un número entero.',
            'id_users.exists' => 'El usuario seleccionado no existe.',
        ]);

        // Solo proceder si se envió un nombre de carpeta
        if (!empty($request->nombre_carpeta)) {
            // Determinar el ID de usuario destino
            $userId = $user->permisos == 0 ? $request->id_users : $user->id_users;
            $userFolder = "carpetas/{$userId}";

            // Convertir nombre a formato válido para el sistema de archivos
            $nombreLimpio = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $request->nombre_carpeta);
            $fullPath = "{$userFolder}/{$nombreLimpio}";

            // Validar que no exista ya en BD ese nombre limpio para ese usuario
            $existe = Carpeta::where('nombre_carpeta', $nombreLimpio)
                ->where('id_users', $userId)
                ->exists();

            if ($existe) {
                return back()->withErrors([
                    'nombre_carpeta' => 'Ya existe una carpeta con ese nombre para este usuario.'
                ])->withInput();
            }

            // Crear carpetas físicas si no existen
            if (!Storage::disk('public')->exists($userFolder)) {
                Storage::disk('public')->makeDirectory($userFolder);
            }
            if (!Storage::disk('public')->exists($fullPath)) {
                Storage::disk('public')->makeDirectory($fullPath);
            }

            // Guardar en base de datos
            $carpeta = new Carpeta();
            $carpeta->nombre_carpeta = $nombreLimpio; // Nombre para rutas
            $carpeta->nombre_original = $request->nombre_carpeta; // Nombre visible al usuario
            $carpeta->id_users = $userId;
            $carpeta->save();
        }

        // Redirección según permisos
        $ruta = $user->permisos == 0
            ? 'crm.admin.carpetas.carpetas'
            : 'crm.user.carpetas.carpetas';

        return redirect()->route($ruta)->with('success', 'Carpeta creada correctamente.');
    }


    //---------------------------------------------------------------------------------------------
    /**
     * Summary of edit
     * @param mixed $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = Auth::user();
        $carpeta = Carpeta::findOrFail($id);

        // Admin puede editar cualquier carpeta
        if ($user->permisos == 0) {
            $usuarios = User::all(); // útil si el formulario permite cambiar el usuario
            return view('crm.admin.carpetas.edit', compact('carpeta', 'usuarios'));
        }

        // Usuario solo puede editar sus propias carpetas
        if ($carpeta->id_users === $user->id_users) {
            $usuario = $user;
            return view('crm.user.carpetas.edit', compact('carpeta', 'usuario'));
        }

        // Si no es ni admin ni dueño, se deniega el acceso
        abort(403, 'No tienes permiso para editar esta carpeta.');
    }

    //---------------------------------------------------------------------------------------------
    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $carpeta = Carpeta::findOrFail($id);

        // Reglas de validación
        $rules = [
            'nombre_carpeta' => 'nullable|string|max:50',
        ];

        // Validar id_users solo si es admin
        if ($user->permisos == 0) {
            $rules['id_users'] = 'required|integer|exists:users,id_users';
        }

        $request->validate($rules, [
            'nombre_carpeta.string' => 'El nombre de la carpeta debe ser una cadena de texto.',
            'nombre_carpeta.max' => 'El nombre de la carpeta no puede tener más de 50 caracteres.',
            'id_users.required' => 'El ID de usuario es obligatorio.',
            'id_users.integer' => 'El ID de usuario debe ser un número entero.',
            'id_users.exists' => 'El usuario seleccionado no existe.',
        ]);

        // Verificar permiso para modificar (dueño o admin)
        if ($carpeta->id_users != $user->id_users && $user->permisos != 0) {
            return back()->withErrors(['permiso' => 'No tienes permiso para modificar esta carpeta.']);
        }

        // Preparar valores
        $nuevoNombreOriginal = $request->nombre_carpeta;
        $nuevoNombreLimpio = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $nuevoNombreOriginal);

        // Validar duplicado (con nombre limpio)
        $existe = Carpeta::where('id_users', $carpeta->id_users)
            ->where('nombre_carpeta', $nuevoNombreLimpio)
            ->where('id_carpeta', '<>', $carpeta->id_carpeta)
            ->exists();

        if ($existe) {
            return back()->withErrors(['nombre_carpeta' => 'Ya existe una carpeta con ese nombre para este usuario.']);
        }

        // Renombrar carpeta física si existe
        $userFolder = 'carpetas/' . $carpeta->id_users;
        $rutaVieja = $userFolder . '/' . $carpeta->nombre_carpeta;
        $rutaNueva = $userFolder . '/' . $nuevoNombreLimpio;

        if (Storage::disk('public')->exists($rutaVieja)) {
            Storage::disk('public')->move($rutaVieja, $rutaNueva);
        } else {
            // Si no existe, crear la nueva carpeta física
            if (!Storage::disk('public')->exists($rutaNueva)) {
                Storage::disk('public')->makeDirectory($rutaNueva);
            }
        }

        // Guardar cambios
        $carpeta->nombre_carpeta = $nuevoNombreLimpio;
        $carpeta->nombre_original = $nuevoNombreOriginal;

        // Solo admin puede cambiar propietario
        if ($user->permisos == 0 && $request->has('id_users')) {
            $carpeta->id_users = $request->id_users;
        }

        $carpeta->save();

        // Redirección según tipo de usuario
        $ruta = $user->permisos == 0
            ? 'crm.admin.carpetas.carpetas'
            : 'crm.user.carpetas.carpetas';

        return redirect()->route($ruta)->with('success', 'Carpeta actualizada correctamente.');
    }


    //---------------------------------------------------------------------------------------------
    /**
     * Eliminar carpeta
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $carpeta = Carpeta::findOrFail($id);

        //-----------------------------------------------------------------------------------------

        // Verificar si el usuario es el propietario o tiene permisos de administrador
        if ($carpeta->id_users != $user->id_users && $user->permisos != 0) {
            return back()->withErrors(['error' => 'No tienes permiso para eliminar esta carpeta.']);
        }

        // Verificar si la carpeta tiene documentos
        if ($carpeta->documentos()->count() > 0) {
            return back()->withErrors(['error' => 'La carpeta no está vacía, no se puede eliminar.']);
        }

        // Eliminar la carpeta física si existe
        $nombreLimpio = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $carpeta->nombre_carpeta);
        $ruta = 'carpetas/' . $carpeta->id_users . '/' . $nombreLimpio;

        if (Storage::disk('public')->exists($ruta)) {
            Storage::disk('public')->deleteDirectory($ruta);
        }

        // Eliminar el registro de la base de datos
        $carpeta->delete();

        // Redirigir
        $ruta = $user->permisos == 0
            ? 'crm.admin.carpetas.carpetas'
            : 'crm.user.carpetas.carpetas';

        return redirect()->route($ruta)->with('success', 'Enlace eliminado correctamente.');
    }

    // Método que devuelve las carpetas en JSON
    public function carpetasPorUsuario($userId)
    {
        $carpetas = Carpeta::where('id_users', $userId)->get(['id_carpeta', 'nombre_original']);
        return response()->json($carpetas);
    }
}
