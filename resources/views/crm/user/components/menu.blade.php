{{-- Menú USUARIO --}}

{{-- Botón Hamburguesa solo visible en móviles --}}
<div class="p-3 d-md-none menu-toggle text-end">
    <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-label="Abrir menú">
        <h5 class="mb-0 offcanvas-title">CRM | <i class="bi bi-list"></i></h5>
    </button>
</div>

{{-- Sidebar Responsive (Bootstrap Offcanvas) --}}
<div class="text-white offcanvas-md offcanvas-start bg-menu-gradient sidebar-narrow menu" tabindex="-1"
    id="sidebarMenu">
    <div class="offcanvas-header d-md-none">
        <h5 class="offcanvas-title">CRM</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>

    <div class="p-3 offcanvas-body d-flex flex-column vh-100">
        <h4 class="mb-4 d-none d-md-block">CRM</h4>

        <ul class="nav flex-column">

            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->routeIs('crm.user.home.home') ? 'active' : '' }}"
                    href="{{ route('crm.user.home.home') }}">
                    <i class="bi bi-house-door"></i> Inicio</a>
            </li>

            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->routeIs('crm.user.perfil.*') ? 'active' : '' }}"
                    href="{{ route('crm.user.perfil.perfil') }}">
                    <i class="bi bi-person"></i> Perfil</a>
            </li>

            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->routeIs('crm.user.carpetas.*') ? 'active' : '' }}"
                    href="{{ route('crm.user.carpetas.carpetas') }}">
                    <i class="bi bi-folder"></i> Carpetas</a>
            </li>

            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->routeIs('crm.user.documentos.*') ? 'active' : '' }}"
                    href="{{ route('crm.user.documentos.documentos') }}">
                    <i class="bi bi-file-text"></i> Documentos</a>
            </li>

            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->routeIs('crm.user.enlaces.*') ? 'active' : '' }}"
                    href="{{ route('crm.user.enlaces.enlaces') }}">
                    <i class="bi bi-link"></i> Enlaces</a>
            </li>


        </ul>

        <div class="mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</div>