{{-- Vista home - Admin --}}

@extends('crm.admin.components.layout')

@section('title', 'Inicio')

@section('content')

    <div class="p-2 ms-1">

        <h1 class="py-4">Bienvenido, {{ Auth::user()->nombre }} </h1>

        <div class="row">

            <div class="mb-3 col-md-3">
                <div class="p-2 rounded bg-light">
                    <p>Total de usuarios: {{ $conteoPermiso1 }}</p>
                </div>
            </div>


            <div class="mb-3 col-md-3">
                <div class="p-2 rounded bg-light">
                    <p>Total de administradores: {{ $conteoPermiso0 }}</p>
                </div>
            </div>

            <div class="mb-3 col-md-6 text-end">
                <div id="datetime" class="p-3 rounded bg-light"></div>
            </div>

            <div class="mb-3 col-md-6">
                <div class="p-2 rounded bg-light">
                    @include('crm.components.calendario')
                </div>
            </div>

            <div class="mb-3 col-md-6">
                <div class="p-2 rounded bg-light">
                    @include('crm.admin.home.logs_sesion', ['logs' => $logs])
                </div>
            </div>

        </div>

    </div>

@endsection