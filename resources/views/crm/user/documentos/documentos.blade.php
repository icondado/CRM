{{-- Vista Documentos - usuario --}}

@extends('crm.user.components.layout')

@section('title', 'Documentos')

@section('content')

    <div class="p-2">
        <div class="row">

            <div class="my-3 col-md-3">
                <div class="p-2 rounded bg-light">
                    <p>Usuario: {{ Auth::user()->nombre }} {{ Auth::user()->apellidos }} </p>
                </div>
            </div>

            <div class="my-3 text-center col-md-6">
                <div id="datetime" class="p-3 rounded bg-light"></div>
            </div>


            <div class="my-3 col-md-3">
                <div class="p-2 rounded bg-light">
                    <p>Total de documentos: {{ $conteoDocumentos }}</p>
                </div>
            </div>

            <div class="mb-3 ol-md-12">
                <div class="p-2 rounded bg-light">

                    <h3 class="text-center lead">Listado de documentos</h3>

                    {{-- Incluimos la vista parcial que muestra la tabla --}}
                    @include('crm.user.documentos.lista')

                </div>
            </div>

        </div>
    </div>

@endsection