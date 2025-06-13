{{-- Modal Editar Administrador - Admin --}}

@foreach ($administradores as $administrador)
    <div class="modal fade" id="modalEditarAdministrador{{ $administrador->id_users }}" tabindex="-1"
        aria-labelledby="modalEditarAdministradorLabel{{ $administrador->id_users }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarAdministradorLabel{{ $administrador->id_users }}">Editar
                        administrador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

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

                <div class="modal-body">
                    <form action="{{ route('crm.admin.admin.update', $administrador->id_users) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">ID Usuario</label>
                            <input type="text" class="form-control" value="{{ $administrador->id_users }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $administrador->nombre }}"
                                required>
                            @error('nombre')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" value="{{ $administrador->apellidos }}"
                                required>
                            @error('apellidos')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">DNI</label>
                            <input type="text" name="dni" class="form-control" value="{{ $administrador->dni }}" required>
                            @error('dni')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control"
                                value="{{ $administrador->direccion }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Código Postal</label>
                            <input type="text" name="codigo_postal" class="form-control"
                                value="{{ $administrador->codigo_postal }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Provincia</label>
                            <input type="text" name="provincia" class="form-control"
                                value="{{ $administrador->provincia }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ $administrador->telefono }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" value="{{ $administrador->email }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control">
                            <small class="form-text text-muted">Dejar en blanco si no desea cambiarla.</small>
                            @error('password')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Permisos</label>
                            <select name="permisos" class="form-select" required>
                                <option value="0" {{ $administrador->permisos == 0 ? 'selected' : '' }}>Administrador</option>
                                <option value="1" {{ $administrador->permisos == 1 ? 'selected' : '' }}>Usuario</option>
                            </select>
                            @error('permisos')
                                <p class="mt-1 text-danger d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control">
                            {{-- Mostrar foto actual si existe --}}
                            @if($administrador->foto)
                                <img id="preview" src="{{ asset('storage/fotos/' . $administrador->foto) }}"
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
                                    preview.style.display = "{{ $administrador->foto ? 'block' : 'none' }}";
                                }
                            });
                        </script>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="activo" class="form-check-input"
                                id="activo{{ $administrador->id_users }}" value="1" {{ $administrador->activo == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo{{ $administrador->id_users }}">Activo</label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Editar administrador</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endforeach