{{-- Modal Nuevo Enlace - Usuario --}}

@extends('crm.user.components.layout2')

@section('title', 'Nuevo Enlace')

@section('content')

    <div class="container mt-4">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mb-3 card">
                    <div class="card-header">
                        <h4 class="mb-0">Agregar Nueva Enlace</h4>
                    </div>

                    <div class="card-body">

                        {{-- Formulario --}}
                        <form action="{{ route('crm.user.enlaces.store') }}" method="POST">
                            @csrf

                            {{-- ID usuario --}}
                            <div class="mb-3">
                                <label for="id_users" class="form-label">Usuario</label>
                                <input type="text" name="id_users" class="form-control"
                                    value="{{ $usuario->nombre }} {{ $usuario->apellidos }}" readonly>
                                {{-- ID usuario oculto para enviar en el formulario --}}
                                <input type="hidden" name="id_users" value="{{ $usuario->id_users }}">
                            </div>

                            {{-- nombre enlace --}}
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Enlace</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" required>
                            </div>

                            {{-- URL --}}
                            <div class="mb-3">
                                <label for="url" class="form-label">URL</label>
                                <input type="url" class="form-control" name="url" id="url" required>
                            </div>

                            {{-- Fecha fin --}}
                            <div class="mb-3">
                                <label for="fecha_fin" class="form-label">Fecha fin (opcional)</label>
                                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
                            </div>

                            {{-- Botones --}}
                            <div class="flex items-center justify-between mt-6">
                                <button type="submit" class="btn btn-primary">
                                    Crear Enlace
                                </button>
                                <a href="{{ route('crm.user.enlaces.enlaces') }}" class="btn btn-danger">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection