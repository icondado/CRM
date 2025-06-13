{{-- Modal Crear Nuevo Enlace - Admin --}}

<div class="modal fade" id="modalNuevoEnlace" tabindex="-1" aria-labelledby="modalNuevoEnlaceLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoEnlaceLabel">Nuevo enlace</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('crm.admin.enlaces.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ID usuario oculto --}}
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" class="form-control"
                            value="{{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}" readonly>
                        <input type="hidden" name="id_users" value="{{ Auth::user()->id_users }}">
                    </div>

                    {{-- nombre enlace --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Enlace</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                    </div>

                    {{-- URL --}}
                    <div class="mb-3">
                        <label for="url" class="form-label">URL</label>
                        <input type="url" class="form-control" name="url" id="url" required>
                    </div>

                    {{-- Fecha fin --}}
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label">Fecha fin (opcional)</label>
                        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="btn btn-primary">
                            Nuevo enlace
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>