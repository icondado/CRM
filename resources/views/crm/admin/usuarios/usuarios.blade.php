{{-- Vista Usuarios - Admin --}}

@extends('crm.admin.components.layout')

@section('title', 'Usuarios')

@section('content')

    <div class="p-2">
        <div class="row">

            <div class="my-3 col-md-3 ">
                <div class="p-2 rounded bg-light">
                    <p>Administrador: {{ Auth::user()->nombre }} {{ Auth::user()->apellidos }} </p>
                </div>
            </div>

            <div class="my-3 col-md-3">
                <div class="p-2 rounded bg-light">
                    <p>Total de usuarios: {{ $conteoPermiso1 }}</p>
                </div>
            </div>

            <div class="my-3 col-md-6 text-end">
                <div id="datetime" class="p-3 rounded bg-light"></div>
            </div>

            <div class="mb-3 col-md-12">
                <div class="p-2 rounded bg-light">

                    <h3 class="text-center lead">Listado de usuarios</h3>

                    {{-- Incluimos la vista parcial que muestra la tabla --}}
                    @include('crm.admin.usuarios.lista')

                </div>
            </div>

        </div>
    </div>

@endsection