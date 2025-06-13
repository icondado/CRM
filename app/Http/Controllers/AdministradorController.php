<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdministradorController extends Controller
{

    /****************************************************************************************************
     * Listado
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Obtener los admins paginados, por ejemplo, 5 documentos por página
        $administradores = User::where('permisos', 0)->paginate(5);
        $conteoPermiso0 = User::where('permisos', 0)->count();

        if ($user->permisos !== 0) {
            abort(403, 'No tienes permiso para editar este tipo de administrador.');
        }

        return view('crm.admin.admin.admin', compact('administradores', 'conteoPermiso0'));
    }

    /****************************************************************************************************
     * Create --> Store Nuevo administrador
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->permisos !== 0) {
            abort(403, 'No tienes permiso para editar este tipo de administrador.');
        }

        return view('crm.admin.admin.nuevo');
    }

    /****************************************************************************************************
     * Nuevo administrador
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //dd($request->file('foto'));
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
        // Crear el nuevo administrador
        $administrador = new User();
        $administrador->fill($data);
        $administrador->password = Hash::make($request->password);
        $administrador->activo = $request->has('activo') ? 1 : 0;
        $administrador->fecha_alta = now();

        //------------------------------------
        if ($request->hasFile('foto')) {
            // Verificar si la carpeta 'fotos' existe en el disco 'public', si no, crearla
            if (!Storage::disk('public')->exists('fotos')) {
                Storage::disk('public')->makeDirectory('fotos');
            }

            // Guardar la foto en 'public/fotos' (storage/app/public/fotos)
            $path = $request->file('foto')->store('fotos', 'public');

            // Guardar solo el nombre de archivo para luego mostrarlo
            $administrador->foto = basename($path);
        }

        //--------------------------------------
        $administrador->save();
        $administrador->update(['id' => $administrador->id_users]);

        //-------------------------------------------------------------------------------------------
        // Redirigir con mensaje de éxito
        return redirect()->route('crm.admin.admin.admin')->with('success', 'Administrador creado correctamente.');
    }

    /****************************************************************************************************
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /****************************************************************************************************
     * edit --> update Editar administrador
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        // Administrador elegido para editar
        $administrador = User::find($id);

        // Usuario Logueado
        $admin = Auth::user();

        if ($admin->permisos !== 0) {
            abort(403, 'No tienes permiso para editar este tipo de administrador.');
        }

        return view('crm.admin.admin.edit', compact('administrador'));
    }

    /**
     * Editar administrador
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {

        $administrador = User::where('id_users', $id)->where('permisos', 0)->firstOrFail();

        // Validar datos-------------------------------------------------------------------------
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
            'foto' => 'nullable|image|max:5120', // Una Imagén y máx 5MB
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

        // Actualizar solo si el dato viene, o mantener el anterior------------------------
        $administrador->nombre = $request->nombre ?? $administrador->nombre;
        $administrador->apellidos = $request->apellidos ?? $administrador->apellidos;
        $administrador->dni = $request->dni ?? $administrador->dni;
        $administrador->direccion = $request->direccion ?? $administrador->direccion;
        $administrador->codigo_postal = $request->codigo_postal ?? $administrador->codigo_postal;
        $administrador->provincia = $request->provincia ?? $administrador->provincia;
        $administrador->telefono = $request->telefono ?? $administrador->telefono;
        $administrador->email = $request->email ?? $administrador->email;
        $administrador->permisos = $request->permisos ?? $administrador->permisos;
        $administrador->activo = $request->has('activo') ? 1 : 0;

        // Foto-----------------------------------------------------------------------------
        if ($request->hasFile('foto')) {
            // Verificar si la carpeta 'fotos' existe en el disco 'public', si no, crearla
            if (!Storage::disk('public')->exists('fotos')) {
                Storage::disk('public')->makeDirectory('fotos');
            }

            // Eliminar la imagen anterior si existe
            if ($administrador->foto && Storage::disk('public')->exists('fotos/' . $administrador->foto)) {
                Storage::disk('public')->delete('fotos/' . $administrador->foto);
            }

            // Guardar la nueva foto
            $path = $request->file('foto')->store('fotos', 'public');

            // Guardar solo el nombre de archivo para luego mostrarlo
            $administrador->foto = basename($path);
        }
        // Password-----------------------------------------------------------------------------
        // Solo cambiar contraseña si fue enviada
        if ($request->filled('password')) {
            $administrador->password = Hash::make($request->password);
        }
        // Save---------------------------------------------------------------------------------
        $administrador->save();
        $administrador->update(['id' => $administrador->id_users]);

        // Route--------------------------------------------------------------------------------
        return redirect()->route('crm.admin.admin.admin')->with('success', 'Administrador actualizado correctamente.');
    }


    /**
     * Eliminar Administrador
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $administrador = User::where('id_users', $id)->where('permisos', 0)->firstOrFail();


        // Eliminar la imagen si existe
        if ($administrador->foto && Storage::disk('public')->exists('fotos/' . $administrador->foto)) {
            try {
                Storage::disk('public')->delete('fotos/' . $administrador->foto);
            } catch (\Exception $e) {
                Log::error("Error al borrar la imagen del administrador {$administrador->id_users}: " . $e->getMessage());
            }
        }

        $administrador->delete();

        return redirect()->route('crm.admin.admin.admin')->with('success', 'Administrador eliminado correctamente.');
    }
}
