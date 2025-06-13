{{-- Modal Editar Documento - Admin --}}

@foreach ($documentos as $documento)
    <div class="modal fade" id="modalEditarDocumento{{ $documento->id_documento }}" tabindex="-1"
        aria-labelledby="modalEditarDocumentoLabel{{ $documento->id_documento }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarDocumentoLabel{{ $documento->id_documento }}">Editar documento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('crm.admin.documentos.update', $documento->id_documento) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Id documento --}}
                        <div class="mb-3">
                            <label for="id_documento" class="form-label">ID Documento</label>
                            <input type="text" name="id_documento" class="form-control"
                                value="{{ $documento->id_documento }}" readonly>
                        </div>

                        {{-- ID usuario --}}
                        <div class="mb-3">
                            <label for="id_users" class="form-label">Propietario</label>
                            <select class="form-control" name="id_users" id="id_users" {{ Auth::user()->permisos != 0 ? 'disabled' : '' }}>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id_users }}" {{ $documento->id_users == $usuario->id_users ? 'selected' : '' }}>
                                        {{ $usuario->nombre }} {{ $usuario->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Carpeta --}}
                        <div class="mb-3">
                            <label for="id_carpeta" class="form-label">Carpeta</label>
                            <select name="id_carpeta" id="id_carpeta" class="form-control" required>
                                @foreach ($carpetas as $carpeta)
                                    <option value="{{ $carpeta->id_carpeta }}" {{ $documento->id_carpeta == $carpeta->id_carpeta ? 'selected' : '' }}>
                                        {{ $carpeta->nombre_carpeta }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- jQuery + AJAX --}}
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function () {
                                // Si tienes un select para usuarios, escuchamos el cambio
                                $('#id_users').on('change', function () {
                                    let userId = $(this).val();
                                    if (userId) {
                                        $.get('/carpetas-por-usuario/' + userId, function (data) {
                                            let currentCarpeta = "{{ $documento->id_carpeta }}"; // Carpeta seleccionada actualmente
                                            $('#id_carpeta').empty();
                                            $('#id_carpeta').append('<option value="">-- Selecciona una carpeta --</option>');
                                            data.forEach(carpeta => {
                                                let selected = carpeta.id_carpeta == currentCarpeta ? 'selected' : '';
                                                $('#id_carpeta').append(`<option value="${carpeta.id_carpeta}" ${selected}>${carpeta.nombre_original}</option>`);
                                            });
                                        });
                                    } else {
                                        $('#id_carpeta').html('<option value="">-- Selecciona una carpeta --</option>');
                                    }
                                });

                                // Opcional: si quieres cargar carpetas al cargar la página para el usuario actual:
                                // simula el evento change para cargar las carpetas
                                $('#id_users').trigger('change');
                            });
                        </script>


                        {{-- Nombre Documento --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Documento</label>
                            <input type="text" class="form-control" name="nombre" id="nombre"
                                value="{{ old('nombre', $documento->nombre) }}" required maxlength="150">
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion"
                                value="{{ old('descripcion') }}" maxlength="150">
                        </div>


                        {{-- Archivo --}}
                        <div class="mb-3">
                            <label for="file" class="form-label">Archivo</label>
                            <input type="file" class="form-control" name="file" id="file"
                                accept=".txt,.pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <p class="form-text">Dejar vacío para conservar el archivo actual.</p>

                        </div>

                        {{-- Botones --}}
                        <div class="mb-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Editar documento</button>
                            <a href="{{ route('crm.admin.documentos.documentos') }}" class="btn btn-danger">Cancelar</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endforeach