{{-- Vista Lista Documentos - Usuario --}}

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

    {{-- Botón para crear nuevo documento --}}
    <div class="mb-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaDocumento">
            Nuevo documento
        </button>
    </div>

    {{-- Tabla de documentos --}}
    <div class="table-responsive">
        <table class="table align-middle table-hover table-bordered">
            <thead class="text-center table-secondary">
                <tr>
                    <th>ID Documento</th>
                    <th>Propietario</th>
                    <th>Carpeta</th>
                    <th>Nombre Documento</th>
                    <th>Descripción</th>
                    <th>Archivo</th>
                    <th>Fecha Alta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documentos as $documento)
                    <tr>
                        <td class='text-center'>{{ $documento->id_documento }}</td>

                        <td class="td-limit">
                            @if ($documento->id_users == $usuario->id_users)
                                {{ $usuario->nombre }} {{ $usuario->apellidos }}
                            @endif
                        </td>

                        <td>{{ $documento->carpeta->nombre_original ?? 'Sin carpeta' }}</td>

                        <td>{{ $documento->nombre }}</td>

                        <td>{{ $documento->descripcion }}</td>

                        <td class="text-center">
                            @php
                                $ext = strtolower(pathinfo($documento->file, PATHINFO_EXTENSION));
                            @endphp

                            @if ($documento->file && $documento->file !== 'sin_archivo')
                                {{-- Mostrar ícono según el tipo de archivo --}}
                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                    <i class="bi bi-file-image"></i> Imagen
                                    <br>
                                    {{-- Imagen con enlace para descargar --}}
                                    <a href="{{ asset('storage/carpetas/' . $documento->file) }}" download
                                        class="mt-1 btn btn-sm btn-outline-primary">
                                        <img src="{{ asset('storage/carpetas/' . $documento->file) }}" alt="Archivo" width="40"
                                            class="mt-1 rounded">
                                    </a>
                                @elseif ($ext === 'pdf')
                                    <i class="bi bi-file-pdf"></i> PDF
                                    <br>
                                    {{-- Enlace para descargar PDF --}}
                                    <a href="{{ asset('storage/carpetas/' . $documento->file) }}" download
                                        class="mt-1 btn btn-sm btn-outline-primary">Descargar</a>
                                @elseif (in_array($ext, ['doc', 'docx']))
                                    <i class="bi bi-file-word"></i> Word
                                    <br>
                                    <a href="{{ asset('storage/carpetas/' . $documento->file) }}" download
                                        class="mt-1 btn btn-sm btn-outline-primary">Descargar</a>
                                @elseif ($ext === 'txt')
                                    <i class="bi bi-file-text"></i> Texto
                                    <br>
                                    <a href="{{ asset('storage/carpetas/' . $documento->file) }}" download
                                        class="mt-1 btn btn-sm btn-outline-primary">Descargar</a>
                                @else
                                    <i class="bi bi-file-earmark"></i> Otro
                                    <br>
                                    <a href="{{ asset('storage/carpetas/' . $documento->file) }}" download
                                        class="mt-1 btn btn-sm btn-outline-primary">Descargar</a>
                                @endif
                            @else
                                <span class="text-muted">Sin archivo</span>
                            @endif

                        </td>

                        <td>{{ \Carbon\Carbon::parse($documento->fecha_alta)->format('d/m/Y') }}</td>

                        <td class="text-center">
                            <div class="gap-2 d-flex justify-content-center">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalEditarDocumento{{ $documento->id_documento }}">
                                    Editar
                                </button>
                                <form action="{{ route('crm.user.documentos.destroy', $documento->id_documento) }}"
                                    method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este documento?');">
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
                        <td colspan="8" class="text-center text-muted">No hay documentos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación si se usa paginate() en el controlador --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $documentos->links('pagination::bootstrap-5') }}
    </div>

</div>


{{-- Modal - Incluimos vistas --}}
@include('crm.user.documentos.nuevo')
@include('crm.user.documentos.edit')