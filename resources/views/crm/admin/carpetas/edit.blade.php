{{-- Modal Editar Carpeta - Admin --}}

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
                    <form action="{{ route('crm.admin.carpetas.update', $carpeta->id_carpeta) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">ID Carpeta</label>
                            <input type="text" class="form-control" value="{{ $carpeta->id_carpeta }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre_carpeta" class="form-control"
                                value="{{ $carpeta->nombre_original }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <select name="id_users" class="form-select" required>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id_users }}" {{ $usuario->id_users == $carpeta->id_users ? 'selected' : '' }}>
                                        {{ $usuario->nombre }} {{ $usuario->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Editar carpeta</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endforeach