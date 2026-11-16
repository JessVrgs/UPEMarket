<x-layout title="UPEMARKET | DASHBOARD">
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
            z-index: 2;
        }

        .logo {
            height: 30px;
        }

        /* Capa translúcida para suavizar el fondo */
        body::before {
            content: "";
            position: absolute;
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

        .navbar img {
            height: 40px;
        }

        .navbar h1 {
            font-size: 20px;
            margin: 0;
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
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-logout:hover {
            background-color: black;
            color: white;
        }

        /* Contenedor Principal del Dashboard */
        .dashboard-container {
            position: relative;
            z-index: 2;
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            flex: 1;
        }

        .welcome-card {
            background: #bd6464;
            color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .welcome-card h2 {
            margin-top: 0;
            font-size: 26px;
        }

        /* Cuadrícula de opciones/módulos */
        .grid-modules {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .module-card {
            background: white;
            color: #1f2937;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-top: 5px solid #bd6464;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: block;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .module-card h3 {
            margin-top: 0;
            color: #bd6464;
            font-size: 20px;
        }

        .module-card p {
            color: #4b5563;
            font-size: 14px;
            margin-bottom: 0;
        }

        .badge-admin {
            background-color: #1f2937;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>

    <!-- Barra Superior -->
    <header class="navbar">
        <div class="brand">
            <img src="{{ asset('img/Logo UPEMarket.png') }}" alt="Logo UPEMarket" class="logo">
        </div>
        <div class="user-info">
            <span class="badge-admin" style="background-color: green;">Estudiante</span>
            <!-- Formulario de Cerrar Sesión -->
            <!--
            </form>-->
            <nav>☰
                <ol>
                    <li><a href="#"></a></li>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf<button type="submit" class="btn-logout">Cerrar Sesión</button>
                </ol>
            </nav>
        </div>
    </header>

    <!-- Contenido del Dashboard -->
    <div class="dashboard-container">

        <!-- Tarjeta de Bienvenida con validación de rol -->
        <div class="welcome-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h2>¡Bienvenido <strong>{{ Auth::user()->nombre ?? 'estudiante' }}</h2>
                    <p style="margin: 0; font-size: 16px; opacity: 0.9;">
                        Sistema de gestión e intercambio comercial de la comunidad UPEMOR.
                    <p><strong>Correo:</strong> {{ Auth::user()->email }} <strong>Carrera:</strong> {{ Auth::user()->carrera ?? 'No especificada' }}</p>
                    </p>
                </div>
                <div>
                    @if(Auth::user()->rol === 'admin')
                        <span class="badge-admin">Administrador</span>
                    @else

                    @endif
                </div>
            </div>
        </div>

        <!-- Secciones y Módulos -->
        <div class="grid-modules">

            <!-- Módulo Común: Publicaciones -->
            <a href="{{ url('/publicaciones') }}" class="module-card">
                <h3>Publicaciones</h3>
                <p>Explora, crea y administra los productos o servicios ofrecidos dentro de la comunidad estudiantil.</p>
            </a>

            <!-- Módulo Común: Categorías -->
            <a href="{{ url('/categorias') }}" class="module-card">
                <h3>Categorías</h3>
                <p>Consulta las diferentes categorías disponibles para clasificar y filtrar los artículos en venta.</p>
            </a>

            <!-- Módulo Exclusivo para Administradores -->
            @if(Auth::user()->rol === 'admin')
                <div class="module-card" style="border-top-color: #1f2937;">
                    <h3 style="color: #1f2937;">⚙️ Gestión de Usuarios</h3>
                    <p>Panel de control exclusivo para administradores para dar de alta, modificar o desactivar cuentas institucionales.</p>
                </div>
            @endif

        </div>
    </div>
</x-layout>
