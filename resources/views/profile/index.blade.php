<x-layout title="UPEMARKET | MI PERFIL">
    <style>
        .profile-container {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            flex: 1;
        }

        .profile-header-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .profile-avatar-large {
            width: 90px;
            height: 90px;
            background: #bd6464;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(189, 100, 100, 0.3);
        }

        .profile-meta h1 {
            margin: 0 0 8px 0;
            font-size: 24px;
            color: #1f2937;
        }

        .profile-meta p {
            margin: 4px 0;
            color: #4b5563;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .badge-role-profile {
            display: inline-block;
            background-color: #fdf2f2;
            color: #bd6464;
            border: 1px solid #f8d7da;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 10px;
        }

        /* Sección de Estadísticas y Opciones */
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
        }

        .profile-card h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #1f2937;
            font-size: 18px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f9fafb;
            font-size: 14px;
            color: #4b5563;
        }

        .stat-item strong {
            color: #1f2937;
            font-size: 16px;
        }

        .btn-action {
            display: block;
            width: 100%;
            background-color: #f9fafb;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            margin-bottom: 12px;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .btn-action:hover {
            background-color: #f3f4f6;
            border-color: #bd6464;
            color: #bd6464;
        }

        .btn-danger-custom {
            background-color: #fff5f5;
            color: #dc2626;
            border: 1px solid #f8d7da;
        }

        .btn-danger-custom:hover {
            background-color: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
            .profile-header-card {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }
            .profile-meta p {
                justify-content: center;
            }
        }
    </style>

    <div class="profile-container">
        <!-- Encabezado con datos del usuario autenticado -->
        <div class="profile-header-card">
            <div class="profile-avatar-large">
                {{ substr(Auth::user()?->nombre ?? 'U', 0, 1) }}
            </div>
            <div class="profile-meta">
                <h1>{{ Auth::user()?->nombre ?? 'Estudiante UPEMOR' }}</h1>
                <p>📧 <strong>Correo institucional:</strong> {{ Auth::user()?->email ?? 'No registrado' }}</p>
                <p>🎓 <strong>Programa educativo:</strong> {{ Auth::user()?->carrera ?? 'Ingeniería en Tecnologías de la Información e Innovación Digital' }}</p>
                <span class="badge-role-profile">
                    {{ Auth::user()?->rol === 'admin' ? 'Administrador del Sistema' : 'Estudiante Activo' }}
                </span>
            </div>
        </div>

        <!-- Panel de Opciones y Estadísticas -->
        <div class="profile-grid">
            <!-- Columna 1: Resumen de Actividad -->
            <div class="profile-card">
                <h3>📊 Tu Actividad en UPEMarket</h3>
                <div class="stat-item">
                    <span>Artículos publicados</span>
                    <strong>{{ \App\Models\Publicacion::where('usuario_id', Auth::id())->count() }}</strong>
                </div>
                <div class="stat-item">
                    <span>Artículos activos</span>
                    <strong>{{ \App\Models\Publicacion::where('usuario_id', Auth::id())->where('oculta', false)->count() }}</strong>
                </div>
                <div class="stat-item">
                    <span>Comunidad</span>
                    <strong>UPEMOR</strong>
                </div>

                <div style="margin-top: 25px;">
                    <a href="{{ route('publications.create') }}" class="btn-action" style="background-color: #bd6464; color: white; border: none;">
                        ➕ Publicar Nuevo Artículo
                    </a>
                </div>
            </div>

            <!-- Columna 2: Configuración y Gestión -->
            <div class="profile-card">
                <h3>⚙️ Configuración de Cuenta</h3>

                <a href="{{ url('/publicaciones') }}" class="btn-action">
                    📦 Ver Mis Artículos en el Marketplace
                </a>

                <a href="#" class="btn-action" onclick="alert('Funcionalidad de edición de perfil próximamente'); return false;">
                    ✏️ Editar Información Personal
                </a>

                <div style="margin-top: 30px; border-top: 1px solid #f3f4f6; padding-top: 20px;">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-action btn-danger-custom" style="cursor: pointer;">
                            🚪 Cerrar Sesión Segura
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
