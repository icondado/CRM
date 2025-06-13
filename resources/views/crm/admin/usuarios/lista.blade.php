{{-- Vista Lista Usuarios - Admin --}}

<div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Mensaje de error de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </ul>
        </div>
    @endif

    {{-- Botón para modal un nuevo usuario --}}
    <div class="mb-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">Nuevo
            usuario</button>
    </div>

    {{-- Tabla responsive --}}
    <div class="table-responsive">
        <table class="table align-middle table-bordered table-hover">
            <thead class="text-center table-secondary">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Dirección</th>
                    <th>CP</th>
                    <th>Provincia</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Permiso</th>
                    <th>Activo</th>
                    <th>Fecha Alta</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Si no hay usuarios, mostrar mensaje --}}
                @if ($usuarios->isEmpty())
                    <tr>
                        <td colspan="14" class="text-center">No hay usuarios que mostrar</td>
                    </tr>
                @else
                    {{-- Mostrar los enlaces --}}
                    @foreach ($usuarios as $usuario)
                        <tr>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td>{{ $usuario->id_users }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->apellidos }}</td>
                            <td>{{ $usuario->dni }}</td>
                            <td>{{ $usuario->direccion }}</td>
                            <td>{{ $usuario->codigo_postal }}</td>
                            <td>{{ $usuario->provincia }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>{{ $usuario->email }}</td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td class="text-center">
                                <span>
                                    {{ $usuario->permisos == 0 ? 'Administrador' : 'Usuario' }}
                                </span>
                            </td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td class="text-center">
                                <span>
                                    {{ $usuario->activo == 1 ? 'Sí' : 'No' }}
                                </span>
                            </td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td>{{ \Carbon\Carbon::parse($usuario->fecha_alta)->format('d/m/Y') }}</td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td class="text-center">
                                @if($usuario->foto)
                                    <img src="{{ asset('storage/fotos/' . $usuario->foto) }}" alt="Foto" width="40" height="40"
                                        class="rounded-circle">
                                @else
                                    <span class="text-muted">Sin foto</span>
                                @endif
                            </td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td class="text-center">
                                <div class="gap-2 d-flex justify-content-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalEditarUsuario{{$usuario->id_users}}">
                                        Editar
                                    </button>
                                    <form action="{{ route('crm.admin.usuarios.destroy', $usuario->id_users) }}" method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{-- Paginación si se usa paginate() en el controlador --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $usuarios->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Modal - Incluimos vistas --}}
@include('crm.admin.usuarios.nuevo')
@include('crm.admin.usuarios.edit')