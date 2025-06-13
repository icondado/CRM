<!DOCTYPE html>
{{-- Administrador --}}
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de CRM')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FullCalendar CSS -->
    <script>
        const endpointEventos = @json(auth()->user()->permiso === 0 ? '/admin/eventos' : '/usuario/eventos');
    </script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/locales-all.global.min.js"></script>

    <!--  Para funcione bien el token CSRF en fetch -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- VITE -->
    @vite('resources/js/app.js')

    <!-- JS personalizado (opcional) -->
    @vite('resources/js/custom/custom.js')

    <!-- CSS personalizado (opcional) -->
    @vite('resources/css/custom/custom.css')
</head>


<body class="min-vh-100">
    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar izquierda --}}
            <div class="p-0 col-12 col-md-2 sticky-top contenidoMenu">
                @include('crm.admin.components.menu')
            </div>

            {{-- Contenido + Footer --}}
            <div class="p-0 col-12 col-md-10 d-flex flex-column">
                <main class="flex-grow-1">
                    @yield('content')
                </main>

                @include('crm.components.footer')
            </div>

        </div>
    </div>

</body>

</html>