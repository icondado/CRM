{{-- Modal Crear Nuevo Administrador - Admin --}}

<div class="modal fade" id="modalNuevoAdministrador" tabindex="-1" aria-labelledby="modalNuevoAdministradorLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoAdministradorLabel">Nuevo administrador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('crm.admin.admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Apellidos --}}
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}"
                            required>
                        @error('apellidos')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- DNI --}}
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" name="dni" class="form-control" value="{{ old('dni') }}" required>
                        @error('dni')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    {{-- Dirección --}}
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                        @error('direccion')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Código Postal --}}
                    <div class="mb-3">
                        <label for="codigo_postal" class="form-label">Código Postal</label>
                        <input type="text" name="codigo_postal" class="form-control" value="{{ old('codigo_postal') }}">
                        @error('codigo_postal')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Provincia --}}
                    <div class="mb-3">
                        <label for="provincia" class="form-label">Provincia</label>
                        <input type="text" name="provincia" class="form-control" value="{{ old('provincia') }}">
                        @error('provincia')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Correo --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Permisos --}}
                    <div class="mb-3">
                        <label for="permisos" class="form-label">Permiso</label>
                        <input type="text" class="form-control" value="Administrador" readonly>
                        <input type="hidden" name="permisos" value="0">
                    </div>

                    {{-- Activo --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="activo" id="activo" value="1" checked>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>

                    {{-- Foto --}}
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                        <img id="preview" src="#" style="display: none; max-width: 100px; margin-top: 10px;" />
                        @error('foto')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const fileInput = document.getElementById("foto");
                            const preview = document.getElementById("preview");

                            fileInput.addEventListener("change", function (event) {
                                const [file] = event.target.files;
                                if (file) {
                                    preview.src = URL.createObjectURL(file);
                                    preview.style.display = "block";
                                } else {
                                    preview.style.display = "none";
                                }
                            });
                        });
                    </script>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Nuevo administrador</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>