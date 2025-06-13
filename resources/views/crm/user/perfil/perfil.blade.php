{{-- Vista Perfil - Usuario --}}

@extends('crm.user.components.layout')

@section('title', 'Perfil')

@section('content')

    <div class="p-2">
        <div class="row">

            <div class="my-4 col-md-8">
                <div class="p-4 rounded ms-2 bg-light">
                    {{-- Incluimos la vista parcial que muestra la tabla --}}
                    @include('crm.user.perfil.lista')
                </div>
            </div>

        </div>
    </div>

@endsection