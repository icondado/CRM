{{-- Vista Lista Carpetas - usuario --}}

<div>

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

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Botón para abrir modal nuevo documento --}}
    <div class="mb-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaCarpeta">
            Nueva carpeta
        </button>
    </div>

    {{-- Tabla de documentos --}}
    <div class="table-responsive">
        <table class="table align-middle table-hover table-bordered">
            <thead class="text-center table-secondary">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($carpetas as $carpeta)
                    <tr>
                        <td>{{ $carpeta->id_carpeta }}</td>

                        <td>{{ $carpeta->nombre_original ?? $carpeta->nombre_carpeta }}</td>

                        <td class="td-limit">
                            {{ $carpeta->usuario->nombre ?? 'Sin usuario' }} {{ $carpeta->usuario->apellidos ?? '' }}
                        </td>

                        <!--Botones-->
                        <td class="text-center">
                            <div class="gap-2 d-flex justify-content-center">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalEditarCarpeta{{ $carpeta->id_carpeta }}">
                                    Editar
                                </button>
                                <form action="{{ route('crm.user.carpetas.destroy', $carpeta->id_carpeta) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este carpeta?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hay carpetas registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación si se usa paginate() en el controlador --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $carpetas->links('pagination::bootstrap-5') }}
    </div>

</div>


{{-- Modal - Incluimos vistas --}}
@include('crm.user.carpetas.nuevo')
@include('crm.user.carpetas.edit')