<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{

    /****************************************************************************************************
     * Listado
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->permisos == 0) {
            // Admin: obtener los usuarios paginados 5 documentos por página
            $conteoPermiso1 = User::where('permisos', 1)->count();
            $usuarios = User::where('permisos', 1)->paginate(5);
            return view('crm.admin.usuarios.usuarios', compact('usuarios', 'conteoPermiso1'));
        } else {
            // Usuario: obtiene solo su propio perfil
            $usuario = $user;
            return view('crm.user.perfil.perfil', compact('usuario'));
        }
    }

    /****************************************************************************************************
     * Summary of create --> store - Nuevo usuario
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->permisos !== 0) {
            abort(403, 'No tienes permiso para editar este tipo de administrador.');
        }

        // Redirigir
        $vista = 'crm.admin.usuarios.nuevo';
        return view($vista);
    }

    /****************************************************************************************************
     * Store a newly created resource in storage - Nuevo Usuario
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        //-------------------------------------------------------------------------------------------
        // Validar los datos recibidos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:150',
            'dni' => 'nullable|regex:/^[0-9]{8}[A-Za-z]$/|unique:users,dni',
            'direccion' => 'nullable|string|max:256',
            'codigo_postal' => 'nullable|regex:/^[0-9]{4,5}$/',
            'provincia' => 'nullable|string|max:100',
            'telefono' => 'nullable|regex:/^[6789][0-9]{8}$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'permisos' => 'required|in:0,1',
            'activo' => 'nullable|boolean',
            'foto' => 'nullable|image|max:5120', // Una Imagén y máx 5MB
        ], [
            'dni.regex' => 'El DNI debe tener 8 números seguidos de una letra (ej. 12345678Z).',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'telefono.regex' => 'El teléfono debe tener 9 dígitos y comenzar por 6, 7, 8 o 9.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'email.unique' => 'Este correo ya está en uso.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'codigo_postal.regex' => 'El código postal debe tener 4 ó 5 dígitos numéricos.',
        ]);

        //-------------------------------------------------------------------------------------------
        // Asegurar valor por defecto para campos no obligatorios que no deben ser NULL
        $data = $request->all();

        // Forzamos cadena vacía si no viene
        $data['apellidos'] = $data['apellidos'] ?? '';
        $data['dni'] = $data['dni'] ?? '';
        $data['telefono'] = $data['telefono'] ?? '';
        $data['direccion'] = $data['direccion'] ?? '';
        $data['provincia'] = $data['provincia'] ?? '';
        $data['codigo_postal'] = $data['codigo_postal'] ?? '';

        //-------------------------------------------------------------------------------------------
        // Crear el nuevo usuario
        $usuario = new User();
        $usuario->fill($data);
        $usuario->password = Hash::make($request->password);
        $usuario->activo = $request->has('activo') ? 1 : 0;
        $usuario->fecha_alta = now();

        //-------------------------------------------------------------------------------------------
        if ($request->hasFile('foto')) {
            // Verificar si la carpeta 'fotos' existe en el disco 'public', si no, crearla
            if (!Storage::disk('public')->exists('fotos')) {
                Storage::disk('public')->makeDirectory('fotos');
            }

            // Guardar la foto en 'public/fotos' (storage/app/public/fotos)
            $path = $request->file('foto')->store('fotos', 'public');

            // Guardar solo el nombre de archivo para luego mostrarlo
            $usuario->foto = basename($path);
        }
        //-------------------------------------------------------------------------------------------
        $usuario->save();
        $usuario->update(['id' => $usuario->id_users]);

        //-------------------------------------------------------------------------------------------
        // Redirigir con mensaje de éxito
        $ruta = 'crm.admin.usuarios.usuarios';
        return redirect()->route($ruta)->with('success', 'Usuario creado correctamente.');
    }

    /****************************************************************************************************
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /****************************************************************************************************
     * Summary of edit --> update - Editar Usuario
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        $user = Auth::user();

        if ($user->permisos == 0) {
            // Admin Todos
            return view('crm.admin.usuarios.edit', compact('usuario'));
        } else {
            if ($user->id === $usuario->id) {
                // User solo él
                return view('crm.user.perfil.edit', compact('usuario'));
            } else {
                abort(403, 'No tienes permiso para editar este usuario.');
            }
        }
    }



    /****************************************************************************************************
     * Summary of update - Editar Usuario
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);
        $user = Auth::user();

        $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'apellidos' => 'nullable|string|max:150',
            'dni' => 'nullable|regex:/^[0-9]{8}[A-Za-z]$/|unique:users,dni,' . $id . ',id_users',
            'direccion' => 'nullable|string|max:256',
            'codigo_postal' => 'nullable|regex:/^[0-9]{4,5}$/',
            'provincia' => 'nullable|string|max:100',
            'telefono' => 'nullable|regex:/^[6789][0-9]{8}$/',
            'email' => 'sometimes|email|unique:users,email,' . $id . ',id_users',
            'password' => 'nullable|string|min:8|confirmed',
            'permisos' => 'nullable|in:0,1',
            'activo' => 'nullable|boolean',
            'foto' => 'nullable|image|max:5120',
        ], [
            'dni.regex' => 'El DNI debe tener 8 números seguidos de una letra (ej. 12345678Z).',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'telefono.regex' => 'El teléfono debe tener 9 dígitos y comenzar por 6, 7, 8 o 9.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'email.unique' => 'Este correo ya está en uso.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'codigo_postal.regex' => 'El código postal debe tener 4 ó 5 dígitos numéricos.',
        ]);

        // Actualizar campos
        $usuario->nombre = $request->nombre ?? $usuario->nombre;
        $usuario->apellidos = $request->apellidos ?? $usuario->apellidos;
        $usuario->dni = $request->dni ?? $usuario->dni;
        $usuario->direccion = $request->direccion ?? $usuario->direccion;
        $usuario->codigo_postal = $request->codigo_postal ?? $usuario->codigo_postal;
        $usuario->provincia = $request->provincia ?? $usuario->provincia;
        $usuario->telefono = $request->telefono ?? $usuario->telefono;
        $usuario->email = $request->email ?? $usuario->email;
        $usuario->permisos = $request->permisos ?? $usuario->permisos;
        $usuario->activo = $request->activo ?? $usuario->activo ?? 1;

        // Foto
        if ($request->hasFile('foto')) {
            if (!Storage::disk('public')->exists('fotos')) {
                Storage::disk('public')->makeDirectory('fotos');
            }
            if ($usuario->foto && Storage::disk('public')->exists('fotos/' . $usuario->foto)) {
                Storage::disk('public')->delete('fotos/' . $usuario->foto);
            }
            $path = $request->file('foto')->store('fotos', 'public');
            $usuario->foto = basename($path);
        }

        // Contraseña
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();
        $usuario->update(['id' => $usuario->id_users]);

        if ($user->permisos == 0) {
            //admin
            return redirect()->route('crm.admin.usuarios.usuarios')->with('success', 'Usuario actualizado correctamente.');
        } else {
            if ($user->id === $usuario->id) {
                //Usuario
                return redirect()->route('crm.user.perfil.perfil')->with('success', 'Has actualizado correctamente.');
            } else {
                abort(403, 'No tienes permiso para editar este usuario.');
            }
        }
    }

    /****************************************************************************************************
     * Summary of destroy - Eliminar Usuario
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Usuario a editar
        $usuario = User::find($id);

        //-------------------------------------------------------------------------------------------
        // Eliminar la imagen si existe
        if ($usuario->foto && Storage::disk('public')->exists('fotos/' . $usuario->foto)) {
            try {
                Storage::disk('public')->delete('fotos/' . $usuario->foto);
            } catch (\Exception $e) {
                Log::error("Error al borrar la imagen del administrador {$usuario->id_users}: " . $e->getMessage());
            }
        }

        //-------------------------------------------------------------------------------------------
        $usuario->delete();

        //-------------------------------------------------------------------------------------------
        // Redirigir con mensaje de éxito
        $ruta = 'crm.admin.usuarios.usuarios';
        return redirect()->route($ruta)->with('success', 'Usuario eliminado correctamente.');
    }
}
