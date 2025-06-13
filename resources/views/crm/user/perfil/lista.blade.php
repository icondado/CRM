{{-- Vista Lista perfil - Usuario --}}

<div class="container mt-4">

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Errores --}}
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

    <div class="card">
        <div class="text-black card-header bg-gradient">
            <h5 class="mb-0">Perfil</h5>
        </div>

        <div class="card-body">
            <div class="row align-items-center">
                {{-- Foto --}}
                <div class="mb-3 text-center col-md-4 mb-md-0">
                    @if ($usuario->foto)
                        <img src="{{ asset('storage/fotos/' . $usuario->foto) }}" alt="Foto de usuario"
                            class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="text-muted">Sin foto</div>
                    @endif
                </div>

                {{-- Información del usuario --}}
                <div class="col-md-8">

                    <div class="mb-2 row">
                        <div class="col-sm-4 fw-bold">Nombre:</div>
                        <div class="col-sm-8">{{ $usuario->nombre }} {{ $usuario->apellidos }}</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-4 fw-bold">DNI:</div>
                        <div class="col-sm-8">{{ $usuario->dni }}</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-4 fw-bold">Dirección:</div>
                        <div class="col-sm-8">{{ $usuario->direccion }}, {{ $usuario->codigo_postal }},
                            {{ $usuario->provincia }}
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-4 fw-bold">Teléfono:</div>
                        <div class="col-sm-8">{{ $usuario->telefono }}</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-4 fw-bold">Email:</div>
                        <div class="col-sm-8">{{ $usuario->email }}</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-4 fw-bold">Permiso:</div>
                        <div class="col-sm-8">{{ $usuario->permisos == 0 ? 'Administrador' : 'Usuario' }}</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-4 fw-bold">Activo:</div>
                        <div class="col-sm-8">{{ $usuario->activo ? 'Sí' : 'No' }}</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-4 fw-bold">Fecha de alta:</div>
                        <div class="col-sm-8">{{ \Carbon\Carbon::parse($usuario->fecha_alta)->format('d/m/Y') }}</div>
                    </div>

                    {{-- Botón para modal de editar --}}
                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalEditarPerfil{{ $usuario->id_users }}">
                            Editar
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modal - Incluimos vistas --}}
@include('crm.user.perfil.edit')