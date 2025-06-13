<!-- Modal Nueva Carpeta - Admin -->

<div class="modal fade" id="modalNuevaCarpeta" tabindex="-1" aria-labelledby="modalNuevaCarpetaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg"> {{-- tamaño grande --}}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevaCarpetaLabel">Nueva carpeta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">

                {{-- Formulario --}}
                <form action="{{ route('crm.admin.carpetas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre_carpeta" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre_carpeta" id="nombre_carpeta" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_users" class="form-label">ID Usuario</label>
                        <select class="form-control" name="id_users" id="id_users" required>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id_users }}">
                                    {{ $usuario->nombre }} {{ $usuario->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
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