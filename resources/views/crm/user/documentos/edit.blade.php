{{-- Modal Editar Documento - Usuario --}}

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
                    <form action="{{ route('crm.user.documentos.update', $documento->id_documento) }}" method="POST">
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
                            <input type="text" class="form-control"
                                value="{{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}" readonly>
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
                                value="{{ old('descripcion', $documento->descripcion) }}" maxlength="150">
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
                            <a href="{{ route('crm.user.documentos.documentos') }}" class="btn btn-danger">Cancelar</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endforeach