<!-- Modal Nueva Carpeta - Usuario -->

<div class="modal fade" id="modalNuevaCarpeta" tabindex="-1" aria-labelledby="modalNuevaCarpetaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg"> {{-- tamaño grande --}}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevaCarpetaLabel">Nueva carpeta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">

                {{-- Formulario ----------------------------}}
                <form action="{{ route('crm.user.carpetas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nombre de carpeta --}}
                    <div class="mb-3">
                        <label for="nombre_carpeta" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre_carpeta" id="nombre_carpeta"
                            value="{{ old('nombre_carpeta') }}" required>
                    </div>

                    {{-- Usuario asignado (solo texto) --}}
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <div class="form-control" readonly>
                            {{ $usuario->nombre }} {{ $usuario->apellidos }}
                        </div>
                        <input type="hidden" name="id_users" value="{{ $usuario->id_users }}">
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="btn btn-primary">
                            Nueva carpeta
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>