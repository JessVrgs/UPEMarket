<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'UPEMARKET' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-completo-upemarket.png') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            height: 100vh;
            overflow: hidden; /* Evita scroll en todo el body, lo delegamos al contenido */
            display: flex;
        }

        /* --- MENÚ LATERAL (SIDEBAR) --- */
        .sidebar {
            width: 260px;
            background-color: #ffffff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
            flex-shrink: 0;
            z-index: 100;
        }

        /* Clase para ocultar el menú empujándolo hacia la izquierda */
        .sidebar.collapsed {
            margin-left: -260px;
        }

        .sidebar-header {
            padding: 20px;
            background-color: #bd6464;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 0.5px;
        }

        .user-profile {
            padding: 20px;
            border-bottom: 1px solid #f3f4f6;
        }

        .user-profile-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .user-avatar {
            background: #bd6464;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 16px;
        }

        .user-info-text {
            font-size: 12px;
            color: #4b5563;
            background: #f9fafb;
            padding: 8px;
            border-radius: 6px;
            line-height: 1.4;
        }

        /* --- ENLACES DEL MENÚ --- */
        .sidebar-nav {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #1f2937;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .sidebar-nav a:hover {
            background-color: #f3f4f6;
            color: #bd6464;
        }

        .submenu-item {
            padding-left: 40px !important;
            font-size: 13px !important;
            color: #6b7280 !important;
            font-weight: 500 !important;
            position: relative;
        }

        .submenu-item::before {
            content: "└";
            position: absolute;
            left: 20px;
            color: #9ca3af;
        }

        /* --- BOTONES DE ACCIÓN --- */
        .btn-create {
            background-color: #bd6464;
            color: white !important;
            text-align: center;
            justify-content: center;
            margin-top: 15px;
            box-shadow: 0 4px 6px rgba(189, 100, 100, 0.2);
        }

        .btn-create:hover {
            background-color: #a05252 !important;
            color: white !important;
            transform: translateY(-1px);
        }

        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid #f3f4f6;
        }

        .btn-logout {
            background-color: transparent;
            color: #4b5563;
            border: 1px solid #d1d5db;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            text-align: center;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background-color: #fef2f2;
            color: #ef4444;
            border-color: #ef4444;
        }

        /* --- CONTENEDOR PRINCIPAL --- */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            min-width: 0; /* Previene desbordamientos en flexbox */
        }

        /* Fondo translúcido aplicado solo al área de contenido, no al menú */
        .main-wrapper::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('img/Patron comercial.png') }}");
            background-size: cover;
            background-position: center;
            opacity: 0.25; /* Ajusta la opacidad del patrón aquí */
            z-index: -1;
        }

        /* --- BARRA SUPERIOR (TOPBAR) --- */
        .topbar {
            background-color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            z-index: 10;
        }

        .hamburger-btn {
            background: transparent;
            border: none;
            color: #1f2937;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .hamburger-btn:hover {
            color: #bd6464;
        }

        .badge-role {
            background-color: #16a34a;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* --- ÁREA DINÁMICA --- */
        .content-area {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto; /* El scroll ocurre solo aquí, no en toda la página */
        }
    </style>
</head>
<body>

    <!-- MENÚ LATERAL -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('img/Logo Completo UPEMarket.png') }}" alt="Logo" style="height: 25px;">
            <h2>UPEM<strong style="color: #fff;">ARKET</strong></h2>
        </div>

        <div class="user-profile">
            <div class="user-profile-header">
                <a href="{{ route('profile.index') }}" class="user-avatar" title="Mi Perfil">👤</a>
                <h4 style="margin: 0; color: #1f2937; font-size: 16px;">{{ Auth::user()?->nombre ?? 'Estudiante' }}</h4>
            </div>
            <div class="user-info-text">
                <strong>Correo:</strong> {{ Auth::user()?->email }}<br>
                <strong>Carrera:</strong> {{ Auth::user()?->carrera ?? 'No especificada' }}
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ url('/publicaciones') }}">🏠 Inicio</a>
            
            <!-- Grupo Publicaciones desglosado -->
            <a href="{{ url('/publicaciones') }}" style="margin-top: 5px;">📦 Publicaciones</a>
            <a href="{{ route('publications.my_posts') }}" class="submenu-item">Mis productos</a>
            
            {{-- <a href="{{ url('/categorias') }}" style="margin-top: 5px;">🏷️ Categorías</a> --}}
            <a href="{{ route('mensajes.index') }}" style="margin-top: 5px;">💬 Mensajes</a>

            @if(Auth::user()?->rol === 'admin')
                <a href="{{ route('users.management') }}" style="margin-top: 5px;">⚙️ Gestión Usuarios</a>
            @endif

            <!-- Botón destacado en el menú -->
            <a href="{{ url('/publicaciones/crear') }}" class="btn-create">+ Crear Publicación</a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </aside>

    <!-- CONTENEDOR DERECHO (TopBar + Contenido) -->
    <div class="main-wrapper">
        
        <header class="topbar">
            <div style="display: flex; align-items: center; gap: 15px;">
                <!-- Botón Hamburguesa que colapsa el menú -->
                <button class="hamburger-btn" onclick="toggleSidebar()" title="Ocultar/Mostrar menú">☰</button>
                <span style="color: #6b7280; font-weight: 500; font-size: 14px;">Panel de control</span>
            </div>
            
            <div class="user-info">
                @if(Auth::user()?->rol === 'admin')
                    <span class="badge-role" style="background-color: #1f2937;">Administrador</span>
                @else
                    <span class="badge-role">Estudiante</span>
                @endif
            </div>
        </header>

        <!-- Aquí se inyectan las vistas de tu compañero -->
        <main class="content-area">
            {{ $slot }}
        </main>

    </div>

    <!-- SCRIPT PARA COLAPSAR EL MENÚ -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            // La clase collapsed empuja el menú a margin-left: -260px, y el contenido principal toma ese espacio fluidamente
            sidebar.classList.toggle('collapsed');
        }
    </script>
</body>
</html>