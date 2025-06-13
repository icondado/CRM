{{-- Modal Vista Editar Enlaces - Admin --}}

@foreach ($enlaces as $enlace)
    <div class="modal fade" id="modalEditarEnlace{{ $enlace->id_enlace }}" tabindex="-1"
        aria-labelledby="modalEditarEnlaceLabel{{ $enlace->id_enlace }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarEnlaceLabel{{ $enlace->id_enlace }}">Editar enlace</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('crm.admin.enlaces.update', $enlace->id_enlace) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ID Enlace --}}
                        <div class="mb-3">
                            <label for="id_enlace" class="form-label">ID Enlace</label>
                            <input type="text" name="id_enlace" class="form-control" value="{{ $enlace->id_enlace }}"
                                readonly>
                        </div>

                        {{-- ID usuario oculto --}}
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text" class="form-control"
                                value="{{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}" readonly>
                            <input type="hidden" name="id_users" value="{{ Auth::user()->id_users }}">
                        </div>

                        {{-- Nombre del enlace --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $enlace->nombre }}"
                                required>
                        </div>

                        {{-- URL --}}
                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="url" name="url" id="url" class="form-control" value="{{ $enlace->url }}" required>
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
                            <button type="submit" class="btn btn-primary">Editar enlace</button>
                            <a href="{{ route('crm.admin.enlaces.enlaces') }}" class="btn btn-danger">Cancelar</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endforeach