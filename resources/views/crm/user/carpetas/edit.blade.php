{{-- Modal Editar Carpeta - Usuario --}}

@foreach ($carpetas as $carpeta)
    <div class="modal fade" id="modalEditarCarpeta{{ $carpeta->id_carpeta }}" tabindex="-1"
        aria-labelledby="modalEditarCarpetaLabel{{ $carpeta->id_carpeta }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarCarpetaLabel{{ $carpeta->id_carpeta }}">Editar carpeta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('crm.user.carpetas.update', $carpeta->id_carpeta) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Id carpeta --}}
                        <div class="mb-3">
                            <label for="id_carpeta" class="form-label">ID Carpeta</label>
                            <input type="text" name="id_carpeta" class="form-control" value="{{ $carpeta->id_carpeta }}"
                                readonly>
                        </div>

                        {{-- Nombre Carpeta --}}
                        <div class="mb-3">
                            <label for="nombre_carpeta" class="form-label">Nombre</label>
                            <input type="text" name="nombre_carpeta" class="form-control"
                                value="{{ old('nombre_carpeta', $carpeta->nombre_original) }}">

                        </div>

                        {{-- ID usuario --}}
                        <div class="mb-3">
                            <label for="id_users" class="form-label">Usuario</label>
                            <input type="text" name="id_users" class="form-control"
                                value="{{ $usuario->nombre }} {{ $usuario->apellidos }}" readonly>
                            {{-- ID usuario oculto para enviar en el formulario --}}
                            <input type="hidden" name="id_users" value="{{ $usuario->id_users }}">
                        </div>

                        {{-- Botones --}}
                        <div class="mb-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Actualizar carpeta</button>
                            <a href="{{ route('crm.user.carpetas.carpetas') }}" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endforeach