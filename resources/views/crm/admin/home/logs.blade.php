{{-- Vista Logs - admin --}}

@extends('crm.admin.components.layout')

@section('title', 'Inicio')

@section('content')

    <div class="p-2">
        <div class="row">

            <div class="my-3 col-md-3 ">
                <div class="p-2 rounded bg-light">
                    <p>Administrador: {{ Auth::user()->nombre }} {{ Auth::user()->apellidos }} </p>
                </div>
            </div>

            <div class="my-3 col-md-3 "></div>

            <div class="my-3 col-md-6 text-end">
                <div id="datetime" class="p-3 rounded bg-light"></div>
            </div>


            <div class="mb-3 col-md-12">
                <div class="p-2 rounded bg-light">

                    <h3 class="my-3 text-center lead">Logs de actividad</h3>

                    @if($logs->count())
                        <div class="table-responsive">

                            <table class="table align-middle table-hover table-bordered w-100">
                                <thead class="text-center table-secondary">
                                    <tr>
                                        <th>ID Log</th>
                                        <th>Usuario</th>
                                        <th>Tipo Usuario</th>
                                        <th>Tabla Afectada</th>
                                        <th>Acción</th>
                                        <th>ID Registro</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $log->id_log }}</td>
                                            <td> @if($log->usuario)
                                                {{ $log->usuario->nombre }} {{ $log->usuario->apellido }}
                                            @else
                                                    Desconocido
                                                @endif
                                            </td>
                                            <td> @if($log->usuario)
                                                {{ $log->usuario->permiso == 0 ? 'Admin' : 'Usuario' }}
                                            @endif
                                            </td>
                                            <td>{{ $log->tabla_afectada }}</td>
                                            <td>{{ ucfirst($log->accion) }}</td>
                                            <td>{{ $log->registro_id }}</td>
                                            <td>{{ $log->descripcion }}</td>
                                            <td>{{ $log->fecha->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Paginación --}}
                            <div class="d-flex justify-content-center">
                                {{ $logs->links() }}
                            </div>

                        </div>
                    @else
                        <p>No hay logs registrados.</p>
                    @endif

                </div>
            </div>

        </div>
    </div>

@endsection