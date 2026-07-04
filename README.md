# CRM - Sistema de Gestión Interna
**BK Programación** | Proyecto desarrollado por: **Irene Condado Alcantarilla**

## DESCRIPCIÓN GENERAL

Este proyecto es un CRM (Customer Relationship Management), diseñado para gestionar usuarios, carpetas, documentos, eventos, enlaces y registrar toda la actividad mediante logs.

Todos los usuarios (administradores y usuarios regulares) se almacenan en una sola tabla en la base de datos. Se diferencian por el campo `permisos`:

-   `0` → Administrador
-   `1` → Usuario

Cada tipo de usuario tiene acceso a un panel distinto con permisos y funcionalidades específicas.

---

## PANEL DE ADMINISTRADOR (permisos = 0)

El administrador tiene un panel completo con las siguientes pestañas:

1. **Inicio**

    - Calendario de eventos: puede ver, crear, editar y eliminar todos los eventos.
    - Estadísticas:
        - Cantidad total de usuarios y administradores.
        - Últimas 5 entradas del log que contengan la palabra clave "sesion".

2. **Administradores**

    - Tabla de administradores.
    - Permite crear, editar y eliminar administradores.

3. **Usuarios**

    - Tabla de usuarios.
    - Permite crear, editar y eliminar usuarios.

4. **Carpetas**

    - Permite crear, modificar y eliminar carpetas.
    - Cada carpeta puede tener un usuario propietario (usuario regular).
    - El usuario propietario podrá acceder a esa carpeta desde su panel.

5. **Documentos**

    - Permite crear, modificar y eliminar documentos.
    - Los documentos deben almacenarse dentro de una carpeta ya creada.
    - Las modificaciones no duplican ni eliminan datos si existe contenido adicional.
    - Solo el administrador o el usuario dueño puede editar o eliminar.

6. **Enlaces**

    - Permite crear, modificar y eliminar enlaces útiles.

7. **Logs**
    - Registro de todas las acciones realizadas en el sistema (crear, modificar, eliminar, etc.).
    - Se guarda información detallada: quién lo hizo, cuándo y qué acción fue.

---

## PANEL DE USUARIO (permisos = 1)

El usuario regular tiene un panel simplificado con las siguientes pestañas:

1. **Inicio**

    - Calendario de eventos:
        - Visualiza sus propios eventos y los creados por administradores.
        - Puede crear, modificar y eliminar sus propios eventos.

2. **Perfil**

    - Visualiza y edita su propia ficha de usuario (información personal).

3. **Carpetas**

    - Solo puede ver, crear, modificar y eliminar sus propias carpetas.

4. **Documentos**

    - Solo puede ver, crear, modificar y eliminar documentos dentro de sus propias carpetas.

5. **Enlaces**
    - Solo puede visualizar los enlaces. No puede crear, modificar ni eliminar.

---

## FUNCIONALIDADES CLAVE

-   **Eventos (Calendario):**
    -   Controlados por permisos.
    -   Los usuarios solo ven los suyos y los de administradores.
    -   Los administradores ven todos.
-   **Relación de Carpetas y Documentos:**

    -   Los documentos deben estar siempre asociados a una carpeta.
    -   Si un documento o carpeta es modificado, no se duplican ni eliminan los datos que ya existan (a menos que sea solicitado).
    -   Solo el dueño (usuario) o el administrador puede hacer cambios o eliminar.

-   **Logs:**
    -   Se registra automáticamente cualquier acción como creación, edición o eliminación.
    -   Guarda información completa del evento: tipo, usuario, fecha y detalles.

---

## REQUISITOS DEL SISTEMA

-   Laravel Framework (PHP)
-   Laravel Breeze para autenticación y scaffolding ligero
-   Vite como gestor y compilador de activos frontend
-   Bootstrap 5 para el diseño responsivo y componentes UI
-   MySQL o MariaDB como sistema gestor de base de datos
-   FullCalendar para la gestión y visualización de eventos en calendario

---

## NOTA FINAL

Este sistema fue diseñado para uso interno de una organización, permitiendo una gestión sencilla y segura de recursos, usuarios y contenido con control de roles.

Autora: Irene Condado Alcantarilla
