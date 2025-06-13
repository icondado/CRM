{{-- calendario --}}

<!-- Título -->
<h3 class="my-3 lead">Calendario de eventos</h3>

<!-- Botón Crear Evento -->
@if (Auth::user()->permisos == 0)
    <div class="mb-3">
        <button id="btnCrear" class="btn btn-primary">
            Crear Evento
        </button>
    </div>
@endif

<div class="rounded">
    <!-- Calendario -->
    <div id="calendar" class="p-4 bg-white "></div>
</div>


<!-- Modal Formulario Nuevo/Editar -->
<div class="modal fade" id="modalEvento" tabindex="-1" aria-labelledby="modalEventoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEvento">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEventoLabel">Crear Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_evento" name="id_evento" />
                    <div class="mb-3">
                        <label for="titulo_evento" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo_evento" name="titulo_evento"
                            maxlength="50" />
                    </div>

                    <div class="mb-3">
                        <label for="id_users" class="form-label">Usuario</label>
                        <select class="form-select" id="id_users" name="id_users" required>
                            <option value="">Seleccione un usuario</option>
                            <!-- Opciones se cargarán por JS -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion_evento" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion_evento" name="descripcion_evento"
                            maxlength="500"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_inicio_evento" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio_evento" name="fecha_inicio_evento" />
                    </div>

                    <div class="mb-3">
                        <label for="fecha_fin_evento" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin_evento" name="fecha_fin_evento" />
                    </div>

                    <div class="mb-3">
                        <label for="hora_inicio_evento" class="form-label">Hora Inicio</label>
                        <input type="time" class="form-control" id="hora_inicio_evento" name="hora_inicio_evento" />
                    </div>
                    <div class="mb-3">
                        <label for="hora_fin_evento" class="form-label">Hora Fin</label>
                        <input type="time" class="form-control" id="hora_fin_evento" name="hora_fin_evento" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal info evento -->
<div class="modal fade" id="modalInfoEvento" tabindex="-1" aria-labelledby="modalInfoEventoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoEventoLabel">Detalles del Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p><strong>Título:</strong> <span id="infoTitulo"></span></p>
                <p><strong>Usuario:</strong> <span id="infoUsuario"></span></p>
                <p><strong>Descripción:</strong> <span id="infoDescripcion"></span></p>
                <p><strong>Fecha inicio:</strong> <span id="infoFechaInicio"></span></p>
                <p><strong>Hora inicio:</strong> <span id="infoHoraInicio"></span></p>
                <p><strong>Fecha fin:</strong> <span id="infoFechaFin"></span></p>
                <p><strong>Hora fin:</strong> <span id="infoHoraFin"></span></p>
            </div>
            @if (Auth::user()->permisos == 0)
                <div class="modal-footer">
                    <button id="btnEditarEvento" class="btn btn-primary">Modificar</button>
                    <button id="btnEliminarEvento" class="btn btn-danger">Eliminar</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            @endif
        </div>
    </div>
</div>