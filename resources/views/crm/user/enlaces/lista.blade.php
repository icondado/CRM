{{-- Vista Lista Enlace - Usuario --}}

<div class="px-5 mt-4 container-fluid">

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

    {{-- Tabla responsive --}}
    <div class="table-responsive">
        <table class="table align-middle table-bordered table-hover">
            <thead class="text-center table-secondary">
                <tr>
                    <th>ID Enlace</th>
                    <th>Propietario</th>
                    <th>Nombre enlace</th>
                    <th>URL</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Fin</th>
                </tr>
            </thead>
            <tbody>
                {{-- Si no hay enlaces, mostrar mensaje --}}
                @if ($enlaces->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No hay enlaces que mostrar</td>
                    </tr>
                @else
                    {{-- Mostrar los enlaces --}}
                    @foreach ($enlaces as $enlace)
                        <tr>
                            <td>{{ $enlace->id_enlace }}</td>

                            {{-- Mostrar nombre y apellidos del usuario --}}
                            <td>
                                {{ $enlace->usuario ? $enlace->usuario->nombre . ' ' . $enlace->usuario->apellidos : 'Usuario no encontrado' }}
                            </td>

                            <td>{{ $enlace->nombre }}</td>

                            {{-- URL clickeable, abre en pestaña nueva --}}
                            <td>
                                <a class="enlace" href="{{ $enlace->url }}" target="_blank" rel="noopener noreferrer">
                                    {{ $enlace->url }}
                                </a>
                            </td>

                            <td>{{ \Carbon\Carbon::parse($enlace->fecha_creacion)->format('d/m/Y') }}</td>

                            <td>
                                {{ $enlace->fecha_fin ? \Carbon\Carbon::parse($enlace->fecha_fin)->format('d/m/Y') : 'N/A' }}
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $enlaces->links() }}
    </div>
</div>