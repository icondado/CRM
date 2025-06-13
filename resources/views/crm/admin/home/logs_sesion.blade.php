{{-- Vista Logs-sesion home - admin --}}

<div class="container mt-4">
    <h2 class="lead">Logs de sesión recientes</h2>

    @if($logs->isEmpty())
        <p>No se encontraron logs de sesión.</p>
    @else
        <ul class="p-2 list-group">
            @foreach($logs as $log)
                <li class="list-group-item">
                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($log->fecha)->format('d/m/Y H:i:s') }} <br>
                    <strong>Descripción:</strong> {{ $log->descripcion }}
                </li>
            @endforeach
        </ul>
    @endif
</div>