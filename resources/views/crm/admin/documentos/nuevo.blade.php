<!-- Modal Nuevo Documento - Admin -->

<div class="modal fade" id="modalNuevaDocumento" tabindex="-1" aria-labelledby="modalNuevaDocumentoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg"> {{-- tamaño grande --}}
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevaDocumentoLabel">Nuevo documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">

                {{-- Formulario --}}
                <form action="{{ route('crm.admin.documentos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Select Propietario --}}
                    <div class="mb-3">
                        <label for="id_users" class="form-label">Propietario</label>
                        <select class="form-control" name="id_users" id="id_users" required>
                            <option value="">-- Selecciona un propietario --</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id_users }}">{{ $usuario->nombre }}
                                    {{ $usuario->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select Carpeta --}}
                    <div class="mb-3">
                        <label for="id_carpeta" class="form-label">Carpeta</label>
                        <select name="id_carpeta" id="id_carpeta" class="form-control" required>
                            <option value="">-- Selecciona una carpeta --</option>
                            {{-- Aquí se cargarán dinámicamente --}}
                        </select>
                    </div>

                    {{-- jQuery para cargar carpetas por usuario --}}
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            $('#id_users').on('change', function () {
                                var userId = $(this).val();

                                if (userId) {
                                    $.ajax({
                                        url: '/carpetas-por-usuario/' + userId,
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function (data) {
                                            $('#id_carpeta').empty();
                                            $('#id_carpeta').append('<option value="">-- Selecciona una carpeta --</option>');
                                            $.each(data, function (key, carpeta) {
                                                // Se usa el nombre original tal cual viene en 'carpeta.nombre_carpeta'
                                                $('#id_carpeta').append('<option value="' + carpeta.id_carpeta + '">' + carpeta.nombre_original + '</option>');
                                            });
                                        },
                                        error: function () {
                                            $('#id_carpeta').empty();
                                            $('#id_carpeta').append('<option value="">No se pudieron cargar las carpetas</option>');
                                        }
                                    });
                                } else {
                                    $('#id_carpeta').empty();
                                    $('#id_carpeta').append('<option value="">-- Selecciona una carpeta --</option>');
                                }
                            });
                        });
                    </script>

                    {{-- Nombre Docuemnto --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Documento</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required maxlength="150">
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="150">
                    </div>


                    {{-- Archivo --}}
                    <div class="mb-3">
                        <label for="file" class="form-label">Archivo</label>
                        <input type="file" class="form-control" name="file" id="file"
                            accept=".txt,.pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="btn btn-primary">
                            Nuevo documento
                        </button>
                        <a href="{{ route('crm.admin.documentos.documentos') }}" class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>