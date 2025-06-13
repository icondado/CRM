{{-- Vista Lista Administrador - Admin --}}

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
            <ul class="mb-0 ">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                <button type=" button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </ul>
        </div>
    @endif

    {{-- Botón para modal un nuevo administrador --}}
    <div class="mb-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#modalNuevoAdministrador">Nuevo administrador</button>
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
                @if ($administradores->isEmpty())
                    <tr>
                        <td colspan="14" class="text-center">No hay administradores que mostrar</td>
                    </tr>
                @else
                    @foreach ($administradores as $administrador)
                        <tr>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td>{{ $administrador->id_users }}</td>
                            <td>{{ $administrador->nombre }}</td>
                            <td>{{ $administrador->apellidos }}</td>
                            <td>{{ $administrador->dni }}</td>
                            <td>{{ $administrador->direccion }}</td>
                            <td>{{ $administrador->codigo_postal }}</td>
                            <td>{{ $administrador->provincia }}</td>
                            <td>{{ $administrador->telefono }}</td>
                            <td>{{ $administrador->email }}</td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td class="text-center">
                                <span>
                                    {{ $administrador->permisos == 0 ? 'Administrador' : 'Usuario' }}
                                </span>
                            </td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td class="text-center">
                                <span>
                                    {{ $administrador->activo == 1 ? 'Sí' : 'No' }}
                                </span>
                            </td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td>{{ \Carbon\Carbon::parse($administrador->fecha_alta)->format('d/m/Y') }}</td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td class="text-center">
                                @if($administrador->foto)
                                    <img src="{{ asset('storage/fotos/' . $administrador->foto) }}" alt="Foto" width="40"
                                        height="40" class="rounded-circle">
                                @else
                                    <span class="text-muted">Sin foto</span>
                                @endif
                            </td>
                            {{-- ----------------------------------------------------------------------------------- --}}
                            <td class="text-center">
                                <div class="gap-2 d-flex justify-content-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalEditarAdministrador{{$administrador->id_users}}">
                                        Editar
                                    </button>
                                    <form action="{{ route('crm.admin.admin.destroy', $administrador->id_users) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este administrador?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                            {{-- ----------------------------------------------------------------------------- --}}
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>
    {{-- Paginación si se usa paginate() en el controlador --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $administradores->links('pagination::bootstrap-5') }}
    </div>
</div>


{{-- Modal - Incluimos vistas --}}
@include('crm.admin.admin.nuevo')
@include('crm.admin.admin.edit')