{{-- Vista Modal Editar Perfil - Usuario --}}


<div class="modal fade" id="modalEditarPerfil{{ $usuario->id_users }}" tabindex="-1"
    aria-labelledby="modalEditarPerfilLabel{{ $usuario->id_users }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarPerfilLabel{{ $usuario->id_users }}">Editar
                    perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('crm.user.perfil.update', $usuario->id_users) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre"
                            value="{{ old('nombre', $usuario->nombre) }}" required>
                    </div>

                    {{-- Apellidos --}}
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos"
                            value="{{ old('apellidos', $usuario->apellidos) }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $usuario->email) }}" required>
                    </div>

                    {{-- Teléfono --}}
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="telefono"
                            value="{{ old('telefono', $usuario->telefono) }}">
                    </div>

                    {{-- Dirección --}}
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="direccion"
                            value="{{ old('direccion', $usuario->direccion) }}">
                    </div>

                    {{-- Código postal y provincia --}}
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="codigo_postal" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" name="codigo_postal"
                                value="{{ old('codigo_postal', $usuario->codigo_postal) }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="provincia" class="form-label">Provincia</label>
                            <input type="text" class="form-control" name="provincia"
                                value="{{ old('provincia', $usuario->provincia) }}">
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto de perfil</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="form-text">Dejar vacío para mantener la actual.</small>
                    </div>

                    {{-- Acciones --}}
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>