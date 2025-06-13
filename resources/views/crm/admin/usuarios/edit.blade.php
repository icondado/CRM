{{-- Modal Vista Editar Usuarios - Admin --}}

@foreach ($usuarios as $usuario)
    <div class="modal fade" id="modalEditarUsuario{{ $usuario->id_users }}" tabindex="-1"
        aria-labelledby="modalEditarUsuarioLabel{{ $usuario->id_users }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarUsuarioLabel{{ $usuario->id_users }}">Editar usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('crm.admin.usuarios.update', $usuario->id_users) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre }}">
                            @error('nombre')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Apellidos --}}
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" value="{{ $usuario->apellidos }}">
                            @error('apellidos')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- DNI --}}
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" name="dni" class="form-control" value="{{ $usuario->dni }}">
                            @error('dni')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control" value="{{ $usuario->direccion }}">
                        </div>

                        {{-- Código Postal --}}
                        <div class="mb-3">
                            <label for="codigo_postal" class="form-label">Código Postal</label>
                            <input type="text" name="codigo_postal" class="form-control"
                                value="{{ $usuario->codigo_postal }}">
                        </div>

                        {{-- Provincia --}}
                        <div class="mb-3">
                            <label for="provincia" class="form-label">Provincia</label>
                            <input type="text" name="provincia" class="form-control" value="{{ $usuario->provincia }}">
                        </div>

                        {{-- Teléfono --}}
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ $usuario->telefono }}">
                        </div>

                        {{-- Correo Electrónico --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" value="{{ $usuario->email }}">
                        </div>

                        {{-- Nueva Contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control">
                            <small class="form-text text-muted">Dejar en blanco si no desea cambiarla.</small>
                            @error('password')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirmar contraseña --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        {{-- Permisos --}}
                        <div class="mb-3">
                            <label for="permisos" class="form-label">Permisos</label>
                            <select name="permisos" id="permisos" class="form-select">
                                <option value="0" {{ $usuario->permisos == 0 ? 'selected' : '' }}>Admin</option>
                                <option value="1" {{ $usuario->permisos == 1 ? 'selected' : '' }}>Usuario</option>
                            </select>
                            @error('permisos')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Foto --}}
                        <div class="mb-4">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control">

                            {{-- Mostrar foto actual si existe --}}
                            @if($usuario->foto)
                                <img id="preview" src="{{ asset('storage/fotos/' . $usuario->foto) }}"
                                    style="max-width: 100px; margin-top: 10px;" />
                            @else
                                <img id="preview" src="" style="display: none; max-width: 100px; margin-top: 10px;" />
                            @endif

                            @error('foto')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>
                        <script>
                            document.getElementById("foto").addEventListener("change", function (event) {
                                const [file] = event.target.files;
                                const preview = document.getElementById("preview");
                                if (file) {
                                    preview.src = URL.createObjectURL(file);
                                    preview.style.display = "block";
                                } else {
                                    // Si no hay archivo seleccionado, opcionalmente ocultar o mantener la foto actual
                                    preview.style.display = "{{ $usuario->foto ? 'block' : 'none' }}";
                                }
                            });
                        </script>

                        {{-- Activo --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" {{ $usuario->activo == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">Activo</label>
                            @error('activo')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Botones --}}
                        <div class="mb-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Editar usuario</button>
                            <a href="{{ route('crm.admin.usuarios.usuarios') }}" class="btn btn-danger">Cancelar</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endforeach