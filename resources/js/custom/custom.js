// Calendario -------------------------------------------------------------------------------------------------------------------------------

function cargarUsuariosEnSelect(usuarios) {
    const select = document.getElementById('id_users');
    select.innerHTML = '<option value="">Seleccione un usuario</option>';

    usuarios.forEach(usuario => {
        const option = document.createElement('option');
        option.value = usuario.id_users;
        option.textContent = `${usuario.nombre} ${usuario.apellidos}`;
        select.appendChild(option);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');
    let modal = new bootstrap.Modal(document.getElementById('modalEvento'));
    let modalInfo = new bootstrap.Modal(document.getElementById('modalInfoEvento'));
    let idEventoSeleccionado = null;

    function abrirModal(titulo) {
        document.getElementById('modalEventoLabel').textContent = titulo;
        modal.show();
    }

    function limpiarFormulario() {
        idEventoSeleccionado = null;
        document.getElementById('formEvento').reset();
    }

    // Inicializa el calendario
    let calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        firstDay: 1, // Lunes como primer día
        buttonText: {
            today: 'Hoy', // Aquí cambias "Today"
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('eventos')
                .then(res => res.json())
                .then(data => {
                    cargarUsuariosEnSelect(data.usuarios);
                    successCallback(data.eventos);
                })
                .catch(error => failureCallback(error));
        },
        selectable: true,
        dateClick: function(info) {
            limpiarFormulario();
            document.getElementById('fecha_inicio_evento').value = info.dateStr;
            document.getElementById('fecha_fin_evento').value = info.dateStr;
            abrirModal('Crear Evento');
        },
        eventClick: function(info) {
            idEventoSeleccionado = info.event.id;

            // Llenar modal info evento
            document.getElementById('infoTitulo').textContent = info.event.title;
            document.getElementById('infoUsuario').textContent = info.event.extendedProps.usuario_nombre || '';
            document.getElementById('infoDescripcion').textContent = info.event.extendedProps.descripcion_evento || '';
            document.getElementById('infoFechaInicio').textContent = info.event.startStr.substring(0, 10);
            document.getElementById('infoHoraInicio').textContent = info.event.extendedProps.hora_inicio_evento || '00:00';
            document.getElementById('infoFechaFin').textContent = info.event.endStr ? info.event.endStr.substring(0, 10) : info.event.startStr.substring(0, 10);
            document.getElementById('infoHoraFin').textContent = info.event.extendedProps.hora_fin_evento || '00:00';

            modalInfo.show();
        },
    });

    if (!calendarEl) {
    console.error('No se encontró el div con id "calendar". ¿Estás seguro de que @include("crm.user.components.calendario") está en la vista actual?');
}

    calendar.render();

    // Botón Crear Evento abre modal vacío
    document.getElementById('btnCrear').addEventListener('click', function() {
        limpiarFormulario();
        abrirModal('Crear Evento');
    });

    // Botón modificar evento en modal info
    document.getElementById('btnEditarEvento').addEventListener('click', function() {
        if (!idEventoSeleccionado) return;

        // Cargar datos en formulario para editar
        let event = calendar.getEventById(idEventoSeleccionado);
        if (!event) return;

        document.getElementById('titulo_evento').value = event.title;
        document.getElementById('id_users').value = event.extendedProps.id_users || '';
        document.getElementById('descripcion_evento').value = event.extendedProps.descripcion_evento || '';
        document.getElementById('fecha_inicio_evento').value = event.startStr.substring(0, 10);
        document.getElementById('hora_inicio_evento').value = event.extendedProps.hora_inicio_evento || '00:00';
        document.getElementById('fecha_fin_evento').value = event.endStr ? event.endStr.substring(0, 10) : event.startStr.substring(0, 10);
        document.getElementById('hora_fin_evento').value = event.extendedProps.hora_fin_evento || '00:00';

        modalInfo.hide();
        abrirModal('Modificar Evento');
    });

    // Botón eliminar evento en modal info
    document.getElementById('btnEliminarEvento').addEventListener('click', function() {
        if (!idEventoSeleccionado) return;
        if (!confirm('¿Seguro que quieres eliminar este evento?')) return;

        fetch(`/admin/eventos/${idEventoSeleccionado}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(res => {
                if (res.ok) {
                    calendar.getEventById(idEventoSeleccionado).remove();
                    limpiarFormulario();
                    modalInfo.hide();
                    alert('Evento eliminado correctamente');
                } else {
                    alert('Error al eliminar evento');
                }
            });
    });

    // Submit formulario crear/modificar evento
    document.getElementById('formEvento').addEventListener('submit', function(e) {
        e.preventDefault();

        let url = idEventoSeleccionado ? `/admin/eventos/${idEventoSeleccionado}` : '/admin/eventos';
        let method = idEventoSeleccionado ? 'PUT' : 'POST';

        let formData = new FormData(this);

        if (method === 'PUT') {
            formData.append('_method', 'PUT'); // Spoof para Laravel
            method = 'POST';
        }

        fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(async res => {
                if (!res.ok) {
                    let data = await res.json();
                    alert('Error: ' + (data.message || 'Error en la solicitud'));
                    return;
                }
                return res.json();
            })
            .then(data => {
                console.log('Eventos cargados:', data.eventos);
                if (data) {
                    calendar.refetchEvents();
                    modal.hide();
                    limpiarFormulario();
                    alert('Evento guardado correctamente');
                }
            });
    });

});


// Fin Calendario -------------------------------------------------------------------------------------------------------------------------------

// Menú -----------------------------------------------------------------------------------------------------------------------------------------

document.addEventListener('DOMContentLoaded', function() {
    const offcanvasElement = document.getElementById('sidebarMenu');
    const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvasElement);

    // Para pruebas: cerrar offcanvas al pulsar el botón close manualmente
    document.querySelectorAll('[data-bs-dismiss="offcanvas"]').forEach(btn => {
        btn.addEventListener('click', () => {
            offcanvas.hide();
        });
    });
});
// Fin Menú -------------------------------------------------------------------------------------------------------------------------------------

// Día y hora -----------------------------------------------------------------------------------------------------------------------------------

    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const date = now.toLocaleDateString('es-ES', options);
        const time = now.toLocaleTimeString('es-ES');
        document.getElementById('datetime').innerHTML = `${date} - ${time}`;
    }

    // Update every second
    setInterval(updateDateTime, 1000);

    // Initial call
    updateDateTime();
// Fin Día y hora -------------------------------------------------------------------------------------------------------------------------------
