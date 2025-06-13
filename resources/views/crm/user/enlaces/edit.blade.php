{{-- Modal Editar Enlace - Usuario --}}

@extends('crm.user.components.layout')

@section('title', 'Editar Enlace')

@section('content')

    <div class="container mt-4">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Editar Enlace</h4>
                    </div>

                    <div class="card-body">
                        {{-- Formulario ----------------------------------------------}}
                        <form action="{{ route('crm.user.enlaces.update', $enlace->id_enlace) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- ID Enlace --}}
                            <div class="mb-3">
                                <label for="id_enlace" class="form-label">ID Enlace</label>
                                <input type="text" name="id_enlace" class="form-control" value="{{ $enlace->id_enlace }}"
                                    readonly>
                            </div>

                            {{-- ID usuario --}}
                            <div class="mb-3">
                                <label for="id_users" class="form-label">Propietario</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}" readonly>
                                <input type="hidden" name="id_users" value="{{ Auth::user()->id_users }}">
                            </div>

                            {{-- Nombre del enlace --}}
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control"
                                    value="{{ $enlace->nombre }}" required>
                            </div>

                            {{-- URL --}}
                            <div class="mb-3">
                                <label for="url" class="form-label">URL</label>
                                <input type="url" name="url" id="url" class="form-control" value="{{ $enlace->url }}"
                                    required>
                            </div>

                            {{-- Fecha Creación --}}
                            <div class="mb-3">
                                <label for="fecha_creacion" class="form-label">Fecha Creación</label>
                                <input type="date" name="fecha_creacion" id="fecha_creacion" class="form-control"
                                    value="{{ $enlace->fecha_creacion ? $enlace->fecha_creacion->format('Y-m-d') : '' }}"
                                    required>
                            </div>

                            {{-- Fecha Fin --}}
                            <div class="mb-3">
                                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                                    value="{{ $enlace->fecha_fin ? $enlace->fecha_fin->format('Y-m-d') : '' }}">
                            </div>

                            {{-- Botones --}}
                            <div class="mb-3 d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Actualizar Enlace</button>
                                <a href="{{ route('crm.user.enlaces.enlaces') }}" class="btn btn-danger">Cancelar</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection