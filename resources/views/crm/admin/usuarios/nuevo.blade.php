{{-- Modal Vista Nuevos Usuarios - Admin --}}

<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="modalNuevoUsuarioLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoUsuarioLabel">Nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('crm.admin.usuarios.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Apellidos --}}
                    <div class="mb-4">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}">
                        @error('apellidos')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DNI --}}
                    <div class="mb-4">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" name="dni" class="form-control" value="{{ old('dni') }}" required>
                        @error('dni')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    {{-- Dirección --}}
                    <div class="mb-4">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                        @error('direccion')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Código Postal --}}
                    <div class="mb-4">
                        <label for="codigo_postal" class="form-label">Código Postal</label>
                        <input type="text" name="codigo_postal" class="form-control" value="{{ old('codigo_postal') }}">
                        @error('codigo_postal')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Provincia --}}
                    <div class="mb-4">
                        <label for="provincia" class="form-label">Provincia</label>
                        <input type="text" name="provincia" class="form-control" value="{{ old('provincia') }}">
                        @error('provincia')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div class="mb-4">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                        @error('telefono')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Correo --}}
                    <div class="mb-4">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Permisos --}}
                    <div class="mb-4">
                        <label for="permisos" class="form-label">Permiso</label>
                        <!-- Campo visible solo para mostrar -->
                        <input type="text" class="form-control" value="Usuario" readonly>
                        <!-- Campo oculto que se envía al backend -->
                        <input type="hidden" name="permisos" value="1">
                    </div>

                    {{-- Activo --}}
                    <div class="flex items-center mb-4 space-x-2">
                        <input type="checkbox" name="activo" value="1" id="activo" checked
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="activo" class="form-label">Activo</label>
                    </div>

                    {{-- Foto --}}
                    <div class="mb-4">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">

                        <img id="preview" src="" style="display: none; max-width: 100px; margin-top: 10px;" />

                        @error('foto')
                            <p class="mt-1 text-danger d-block">{{ $message }}</p>
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
                                    preview.src = "#";
                                    preview.style.display = "none";
                                }
                            });
                        });
                    </script>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            Nuevo usuario
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>