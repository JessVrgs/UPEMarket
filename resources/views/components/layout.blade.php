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
            background-image: url("{{ asset('img/Patron comercial.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .logo {
            height: 35px;
        }

        /* Capa translúcida para suavizar el fondo */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.75);
            z-index: 1;
        }

        /* Barra de navegación superior */
        .navbar {
            position: relative;
            z-index: 2;
            background-color: #bd6464;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar .brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar .brand h1 {
            font-size: 22px;
            margin: 0;
            letter-spacing: 0.5px;
            color: white;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-logout {
            background-color: white;
            color: #bd6464;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
            width: 100%;
            text-align: left;
        }

        .btn-logout:hover {
            background-color: black;
            color: white;
        }

        /* Botón de Hamburguesa */
        .hamburger-btn {
            background: transparent;
            border: 2px solid white;
            color: white;
            font-size: 20px;
            padding: 4px 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .hamburger-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Menú Lateral Desplegable (Drawer) */
        .side-drawer {
            position: fixed;
            top: 0;
            right: -320px;
            width: 300px;
            height: 100%;
            background-color: #ffffff;
            box-shadow: -5px 0 25px rgba(0,0,0,0.15);
            z-index: 100;
            transition: right 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            padding: 25px;
        }

        .side-drawer.open {
            right: 0;
        }

        .drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .drawer-header h3 {
            margin: 0;
            color: #bd6464;
            font-size: 18px;
        }

        .close-drawer {
            background: transparent;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #4b5563;
        }

        /* Enlaces y Submenús */
        .drawer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow-y: auto;
        }

        .drawer-links a {
            display: block;
            padding: 10px 15px;
            color: #1f2937;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.2s, color 0.2s;
        }

        .drawer-links a:hover {
            background-color: #f3f4f6;
            color: #bd6464;
        }

        /* Estilo para las subopciones */
        .submenu-item {
            padding-left: 35px !important;
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

        .submenu-item:hover {
            color: #bd6464 !important;
            background-color: #f9fafb !important;
        }

        /* Fondo oscuro al abrir el menú */
        .drawer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 99;
            display: none;
        }

        .drawer-overlay.open {
            display: block;
        }

        .badge-role {
            background-color: #16a34a;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-admin {
            background-color: #1f2937;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<!-- Overlay oscuro de fondo al abrir el menú -->
<div class="drawer-overlay" id="drawerOverlay" onclick="toggleMenu()"></div>

<!-- Menú Lateral Desplegable (Hamburguesa) -->
<div class="side-drawer" id="sideDrawer">
    <div class="drawer-header">
        <h3>Menú UPEMarket</h3>
        <button class="close-drawer" onclick="toggleMenu()">&times;</button>
    </div>

    <!-- Datos del usuario -->
    <div style="margin-bottom: 20px; border-bottom: 1px solid #f3f4f6; padding-bottom: 15px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
            <a href="{{ route('profile.index') }}" style="background: #bd6464; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 16px;" title="Mi Perfil">👤</a>
            <h4 style="margin: 0; color: #1f2937; font-size: 16px;">{{ Auth::user()?->nombre ?? 'Estudiante' }}</h4>
        </div>
        <div style="font-size: 12px; color: #4b5563; background: #f3f4f6; padding: 8px 10px; border-radius: 6px; line-height: 1.4;">
            <strong>Correo:</strong> {{ Auth::user()?->email }}<br>
            <strong>Carrera:</strong> {{ Auth::user()?->carrera ?? 'No especificada' }}
        </div>
    </div>

    <!-- Enlaces del Menú -->
    <ul class="drawer-links">
        <li><a href="{{ url('/publicaciones') }}">📦 Publicaciones</a></li>
        <li><a href="{{ route('publications.my_posts') }}" class="submenu-item">Mis publicaciones</a></li>

        <li style="margin-top: 5px;"><a href="{{ url('/categorias') }}">🏷️ Categorías</a></li>

        <!-- Botón de Chats / Mensajes Directos -->
        <li style="margin-top: 5px;"><a href="{{ route('mensajes.index') }}">💬 Mensajes</a></li>

        @if(Auth::user()?->rol === 'admin')
            <li style="margin-top: 5px;"><a href="{{ route('users.management') }}">⚙️ Gestión de Usuarios</a></li>
        @endif

        <li style="margin-top: auto; border-top: 1px solid #f3f4f6; padding-top: 15px;">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </li>
    </ul>
</div>

<!-- Barra Superior Común -->
<header class="navbar">
    <div class="brand">
        <img src="{{ asset('img/Logo Completo UPEMarket.png') }}" alt="Logo UPEMarket" class="logo">
        <h1>UPEM<strong style="color: #ff0000">ARKET</strong></h1>
    </div>
    <div class="user-info">
        @if(Auth::user()?->rol === 'admin')
            <span class="badge-admin">Administrador</span>
        @else
            <span class="badge-role">Estudiante</span>
        @endif

        <!-- Botón Hamburguesa que activa el menú -->
        <button class="hamburger-btn" onclick="toggleMenu()">☰</button>
    </div>
</header>

<!-- Contenido Dinámico de las Vistas -->
{{ $slot }}

<!-- Script global para controlar la apertura y cierre del menú -->
<script>
    function toggleMenu() {
        const drawer = document.getElementById('sideDrawer');
        const overlay = document.getElementById('drawerOverlay');
        drawer.classList.toggle('open');
        overlay.classList.toggle('open');
    }
</script>
</body>
</html>
