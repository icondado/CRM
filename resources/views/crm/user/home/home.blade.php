{{-- USUARIO --}}

@extends('crm.user.components.layout')

@section('title', 'Inicio')

@section('content')

    <div class="p-2 ms-1">

        <div class="row">

            <div class="my-3 col-md-6">
                <h1 class="my-4">Bienvenido, {{ Auth::user()->nombre }} </h1> {{-- Usuario Logueado --}}
            </div>

            <div class="mt-5 col-md-4 text-end">
                <div id="datetime" class="p-3 rounded bg-light"></div>
            </div>


            <div class="mb-3 col-md-10">
                <div class="p-2 rounded bg-light">

                    @include('crm.components.calendario')

                </div>
            </div>

        </div>

@endsection