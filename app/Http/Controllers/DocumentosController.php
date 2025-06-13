<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Carpeta;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentosController extends Controller
{
    //------------------------------------------------------------------------------------------------
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $carpetas = Carpeta::All();

        if ($user->permisos == 0) {
            // Obtener los documentos paginados 5 documentos por página
            $documentos = Documento::paginate(5);
            $conteoDocumentos = Documento::count();
            $usuarios = User::all();

            return view('crm.admin.documentos.documentos', compact('documentos', 'usuarios', 'conteoDocumentos', 'carpetas'));
        } else {
            // Usuario ve solo sus propias carpetas
            $documentos = Documento::where('id_users', $user->id_users)->paginate(10);
            $conteoDocumentos = Documento::where('id_users', $user->id_users)->count();
            $usuario = $user;
            return view('crm.user.documentos.documentos', compact('documentos', 'usuario', 'conteoDocumentos', 'carpetas'));
        }
    }

    //------------------------------------------------------------------------------------------------
    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $usuarios = User::all();
        $carpetas = Carpeta::all();
        $user = Auth::user();

        // Redirigir
        if ($user->permisos == 0) {
            // Obtener los documentos paginados, por ejemplo, 10 documentos por página
            $documentos = Documento::paginate(10);
            $usuarios = User::all();

            return view('crm.admin.documentos.nuevo', compact('carpetas', 'documentos', 'usuarios'));
        } else {
            // Usuario ve solo sus propias carpetas
            $documentos = Documento::where('id_users', $user->id_users)->paginate(10);
            $carpetas = Carpeta::where('id_users', $user->id_users)->get();
            return view('crm.user.documentos.nuevo', compact('carpetas', 'documentos'));
        }
    }

    //------------------------------------------------------------------------------------------------
    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validar datos recibidos
        $request->validate([
            'id_users' => 'required|integer|exists:users,id_users', // Usuario propietario (requerido)
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:150',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt|max:2048',
            'id_carpeta' => 'required|integer|exists:carpetas,id_carpeta',
        ], [
            'nombre.required' => 'El nombre del documento es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 150 caracteres.',
            'file.mimes' => 'El archivo debe ser de tipo: jpg, jpeg, png, pdf, doc, docx o txt.',
            'file.max' => 'El archivo no debe superar los 2MB.',
            'id_carpeta.required' => 'Debe seleccionar una carpeta.',
        ]);

        // Buscar la carpeta para verificar que pertenezca al usuario seleccionado
        $carpeta = Carpeta::findOrFail($request->id_carpeta);

        if ($carpeta->id_users != $request->id_users) {
            return back()->withErrors(['id_carpeta' => 'La carpeta no pertenece al usuario seleccionado.'])->withInput();
        }

        // Verificar que no exista documento con mismo nombre en la misma carpeta
        $existe = Documento::where('nombre', $request->nombre)
            ->where('id_carpeta', $request->id_carpeta)
            ->exists();

        if ($existe) {
            return back()->withErrors(['nombre' => 'Ya existe un documento con ese nombre en la carpeta seleccionada.'])->withInput();
        }

        // Crear el documento
        $documento = new Documento();
        $documento->id_users = $user->permisos == 0 ? $request->id_users : $user->id_users;
        $documento->nombre = $request->nombre;
        $documento->descripcion = $request->descripcion;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Limpiar nombre carpeta para filesystem
            $nombreLimpioCarpeta =  $carpeta->nombre_limpio;

            // Construir ruta destino: carpetas/{id_users}/{nombre_carpeta}
            $rutaCarpeta = 'carpetas/' . $carpeta->id_users . '/' . $nombreLimpioCarpeta;

            // Crear carpeta si no existe
            if (!Storage::disk('public')->exists($rutaCarpeta)) {
                Storage::disk('public')->makeDirectory($rutaCarpeta);
            }

            // Nombre archivo con timestamp para evitar colisiones
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file->getClientOriginalName());

            // Guardar archivo
            $file->storeAs($rutaCarpeta, $filename, 'public');

            // Guardar ruta relativa del archivo en BD
            $documento->file = $carpeta->id_users . '/' . $nombreLimpioCarpeta . '/' . $filename;
        } else {
            $documento->file = 'sin_archivo';
        }

        $documento->fecha_alta = now();
        $documento->id_carpeta = $request->id_carpeta;
        $documento->save();

        // Redirigir según permisos
        $ruta = $user->permisos == 0
            ? 'crm.admin.documentos.documentos'
            : 'crm.user.documentos.documentos';

        return redirect()->route($ruta)->with('success', 'Documento creado correctamente.');
    }


    //------------------------------------------------------------------------------------------------
    /**
     * Summary of show
     * @param string $id
     * @return void
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Summary of edit
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        $documento = Documento::findOrFail($id);
        $user = Auth::user();

        $esAdmin = $user->permisos == 0;

        // Solo admin puede editar todos, otros solo los suyos
        if (!$esAdmin && $documento->id_users != $user->id_users) {
            abort(403, 'No tienes permisos para editar este documento.');
        }

        // Admin ve todos los usuarios, usuario normal solo el suyo
        $usuarios = $esAdmin
            ? User::all()
            : User::where('id_users', $user->id_users)->get();

        // Carpeta solo del propietario actual
        $carpetas = Carpeta::where('id_users', $documento->id_users)->get();

        // Redirigir
        $vista = $esAdmin
            ? 'crm.admin.documentos.edit'
            : 'crm.user.documentos.edit';

        return view($vista, compact('documento', 'usuarios', 'carpetas'));
    }


    //------------------------------------------------------------------------------------------------
    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $documento = Documento::findOrFail($id);
        $user = Auth::user();

        // Validar permisos: solo admins o dueño del documento
        if ($user->permisos != 0 && (int)$documento->id_users !== (int)$user->id_users) {
            abort(403, 'No tienes permisos para actualizar este documento.');
        }

        // Validar formularios
        $request->validate([
            'id_users' => 'nullable|integer|exists:users,id_users',
            'nombre' => 'nullable|string|max:150',
            'descripcion' => 'nullable|string|max:150',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt|max:2048',
            'id_carpeta' => 'nullable|integer|exists:carpetas,id_carpeta',
        ], [
            'nombre.max' => 'El nombre no debe exceder los 150 caracteres.',
            'file.mimes' => 'El archivo debe ser de tipo: jpg, jpeg, png, pdf, doc, docx o txt.',
            'file.max' => 'El archivo no debe superar los 2MB.',
        ]);


        // Validar que solo admin pueda cambiar id_users
        if ($request->has('id_users')) {
            if ($user->permisos != 0) {
                // Ignorar cambio de propietario para usuarios no admin
                $idUserNuevo = $documento->id_users;
            } else {
                $idUserNuevo = $request->id_users;
            }
        } else {
            $idUserNuevo = $documento->id_users;
        }

        // Validar que la carpeta pertenece al nuevo usuario
        $idCarpetaNueva = $request->id_carpeta ?? $documento->id_carpeta;

        $carpeta = Carpeta::where('id_carpeta', $idCarpetaNueva)
            ->where('id_users', $idUserNuevo)
            ->first();

        if (!$carpeta) {
            return back()->withErrors(['id_carpeta' => 'La carpeta no existe o no pertenece al usuario seleccionado.']);
        }

        $nombreNuevo = $request->nombre;
        $nombreAnterior = $documento->nombre;
        $idUserAnterior = $documento->id_users;
        $idCarpetaAnterior = $documento->id_carpeta;
        $archivoAnterior = $documento->file;

        $rutaArchivoAnterior = null;
        if ($archivoAnterior && $archivoAnterior != 'sin_archivo') {
            // La ruta anterior completa (carpetas/{idUserAnterior}/{nombreCarpetaAnterior}/{archivo})
            $carpetaAnterior = Carpeta::find($idCarpetaAnterior);
            $nombreCarpetaAnterior = $carpetaAnterior ? $carpetaAnterior->nombre_limpio : 'sin_carpeta';

            $rutaArchivoAnterior = "carpetas/{$idUserAnterior}/{$nombreCarpetaAnterior}/" . basename($archivoAnterior);
        }

        // Nombre carpeta nueva y ruta destino
        $carpetaNuevaNombre = $carpeta->nombre_limpio;
        $rutaNuevaCarpeta = "carpetas/{$idUserNuevo}/{$carpetaNuevaNombre}";

        // Limpieza de nombre de archivo
        $limpiarNombre = function ($nombre) {
            return preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($nombre, PATHINFO_FILENAME));
        };

        // Subió archivo nuevo
        if ($request->hasFile('file')) {
            if ($rutaArchivoAnterior && Storage::disk('public')->exists($rutaArchivoAnterior)) {
                Storage::disk('public')->delete($rutaArchivoAnterior);
            }

            if (!Storage::disk('public')->exists($rutaNuevaCarpeta)) {
                Storage::disk('public')->makeDirectory($rutaNuevaCarpeta);
            }

            $file = $request->file('file');
            $nuevoNombreArchivo = time() . '_' . $limpiarNombre($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

            $file->storeAs($rutaNuevaCarpeta, $nuevoNombreArchivo, 'public');

            $documento->file = "{$idUserNuevo}/{$carpetaNuevaNombre}/{$nuevoNombreArchivo}";
        } else {
            // No subió archivo nuevo, pero puede haber cambios de carpeta, usuario o nombre
            if ($rutaArchivoAnterior && Storage::disk('public')->exists($rutaArchivoAnterior)) {
                $extension = pathinfo($archivoAnterior, PATHINFO_EXTENSION);
                $nuevoNombreArchivo = time() . '_' . $limpiarNombre($nombreNuevo) . '.' . $extension;

                $cambioUsuario = $idUserAnterior != $idUserNuevo;
                $cambioCarpeta = $idCarpetaAnterior != $idCarpetaNueva;
                $cambioNombre = $nombreAnterior != $nombreNuevo;

                if ($cambioUsuario || $cambioCarpeta || $cambioNombre) {
                    if (!Storage::disk('public')->exists($rutaNuevaCarpeta)) {
                        Storage::disk('public')->makeDirectory($rutaNuevaCarpeta);
                    }

                    $rutaNuevaArchivo = $rutaNuevaCarpeta . '/' . $nuevoNombreArchivo;

                    Storage::disk('public')->move($rutaArchivoAnterior, $rutaNuevaArchivo);

                    $documento->file = "{$idUserNuevo}/{$carpetaNuevaNombre}/{$nuevoNombreArchivo}";
                }
            }
        }

        // Guardar datos actualizados
        $documento->id_users = $idUserNuevo;
        $documento->id_carpeta = $idCarpetaNueva;
        $documento->nombre = $nombreNuevo;
        $documento->descripcion = $request->descripcion;
        $documento->save();

        // Redirigir según tipo de usuario
        $ruta = $user->permisos == 0
            ? 'crm.admin.documentos.documentos'
            : 'crm.user.documentos.documentos';

        return redirect()->route($ruta)->with('success', 'Documento actualizado correctamente.');
    }


    //------------------------------------------------------------------------------------------------
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $documento = Documento::findOrFail($id);
        $user = Auth::user();

        // Verificar si el usuario es el propietario o tiene permisos de administrador
        if ($documento->id_users !== $user->id_users && $user->permisos !== 0) {
            return back()->withErrors(['error' => 'No tienes permiso para eliminar este documento.']);
        }


        // Eliminar el archivo si no es 'sin_archivo'
        if ($documento->file !== 'sin_archivo' && Storage::disk('public')->exists('carpetas/' . $documento->file)) {
            Storage::disk('public')->delete('carpetas/' . $documento->file);
        }


        // Eliminar el registro de la base de datos
        $documento->delete();

        // Redirigir
        $ruta = $user->permisos == 0
            ? 'crm.admin.documentos.documentos'
            : 'crm.user.documentos.documentos';

        return redirect()->route($ruta)->with('success', 'Documento eliminado correctamente.');
    }
}
