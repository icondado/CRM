<!-- Modal Nuevo Documento - Usuario -->

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
                <form action="{{ route('crm.user.documentos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ID usuario --}}
                    <div class="mb-3">
                        <label for="id_users" class="form-label">Propietario</label>
                        <input type="text" class="form-control"
                            value="{{Auth::user()->nombre }} {{ Auth::user()->apellidos }}" readonly>
                        {{-- ID usuario oculto para enviar en el formulario --}}
                        <input type="hidden" name="id_users" value="{{ Auth::user()->id_users }}">
                    </div>

                    @php
                        $usuarioId = auth()->user()->id_users;
                    @endphp

                    {{-- Select Carpeta --}}
                    <select name="id_carpeta" id="id_carpeta" class="form-control" required>
                        <option value="">-- Selecciona una carpeta --</option>
                        @foreach ($carpetas as $carpeta)
                            @if ($carpeta->id_users == $usuarioId)
                                <option value="{{ $carpeta->id_carpeta }}">
                                    {{ $carpeta->nombre_original }}
                                </option>
                            @endif
                        @endforeach
                    </select>

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
                        <a href="{{ route('crm.user.documentos.documentos') }}" class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>