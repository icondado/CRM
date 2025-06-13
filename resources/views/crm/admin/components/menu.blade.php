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

                <a class="nav-link text-white {{ request()->is('admin') ? 'fw-bold' : '' }}" href="/admin"><i
                        class="bi bi-house-door"></i> Inicio</a>
            </li>
            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->is('admin/administradores*') ? 'fw-bold' : '' }}"
                    href="/admin/administradores">
                    <i class="bi bi-person"></i> Administradores</a>
            </li>
            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->is('admin/usuarios*') ? 'fw-bold' : '' }}"
                    href="/admin/usuarios">
                    <i class="bi bi-people"></i> Usuarios</a>
            </li>
            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->is('admin/carpetas*') ? 'fw-bold' : '' }}"
                    href="/admin/carpetas">
                    <i class="bi bi-folder"></i> Carpetas</a>
            </li>
            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->is('admin/documentos*') ? 'fw-bold' : '' }}"
                    href="/admin/documentos">
                    <i class="bi bi-file-text"></i> Documentos</a>
            </li>
            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->is('admin/enlaces*') ? 'fw-bold' : '' }}"
                    href="/admin/enlaces">
                    <i class="bi bi-link"></i> Enlaces</a>
            </li>
            <li class="mb-2 nav-item">
                <a class="nav-link text-white {{ request()->is('admin/logs*') ? 'fw-bold' : '' }}" href="/admin/logs">
                    <i class="bi bi-journal-text"></i> Logs</a>
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