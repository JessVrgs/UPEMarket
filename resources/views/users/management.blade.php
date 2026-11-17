<x-layout title="UPEMARKET | GESTIÓN DE USUARIOS">
    <style>
        .admin-container {
            position: relative;
            z-index: 2;
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .page-header {
            background: white;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            margin-bottom: 25px;
            border-left: 5px solid #bd6464;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 24px;
            color: #1f2937;
        }

        .page-header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #6b7280;
        }

        .users-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border: 1px solid #f3f4f6;
            overflow: hidden;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .users-table th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: 700;
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .users-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            color: #4b5563;
            vertical-align: middle;
        }

        .users-table tr:last-child td {
            border-bottom: none;
        }

        .users-table tr:hover {
            background-color: #f9fafb;
        }

        .user-profile-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-sm {
            background: #bd6464;
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            flex-shrink: 0;
        }

        .user-meta h4 {
            margin: 0;
            color: #1f2937;
            font-size: 14px;
            font-weight: 600;
        }

        .user-meta p {
            margin: 2px 0 0 0;
            font-size: 12px;
            color: #6b7280;
        }

        .badge-role-user {
            background-color: #d1fae5;
            color: #065f46;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-role-admin {
            background-color: #1f2937;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-action {
            background-color: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-action:hover {
            background-color: #bd6464;
            color: white;
            border-color: #bd6464;
        }

        .empty-state {
            padding: 50px 20px;
            text-align: center;
        }
    </style>

    <div class="admin-container">
        <!-- Encabezado -->
        <div class="page-header">
            <div>
                <h1>Gestión de Usuarios</h1>
                <p>Administra los miembros registrados en la comunidad UPEMarket</p>
            </div>
            <div>
                <span style="background: #fdf2f2; color: #bd6464; border: 1px solid #f8d7da; padding: 8px 14px; border-radius: 8px; font-weight: 600; font-size: 13px;">
                    🛡️ Panel Exclusivo Administrador
                </span>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 14px;">
                ✔ {{ session('success') }}
            </div>
        @endif

        <!-- Contenedor de la Tabla -->
        <div class="users-card">
            <div class="table-responsive">
                <table class="users-table">
                    <thead>
                    <tr>
                        <th>Estudiante / Usuario</th>
                        <th>Carrera</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        // Obtenemos todos los usuarios registrados en la base de datos
                        $usuarios = \App\Models\User::all();
                    @endphp

                    @forelse($usuarios as $usr)
                        <tr>
                            <td>
                                <div class="user-profile-cell">
                                    <div class="user-avatar-sm">
                                        {{ substr($usr->nombre ?? $usr->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="user-meta">
                                        <h4>{{ $usr->nombre ?? $usr->name ?? 'Sin nombre' }}</h4>
                                        <p>Registrado el {{ $usr->created_at?->format('d/m/Y') ?? 'Reciente' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $usr->carrera ?? 'Ingeniería en Tecnologías de la Información' }}</td>
                            <td>{{ $usr->email }}</td>
                            <td>
                                @if($usr->rol === 'admin')
                                    <span class="badge-role-admin">Administrador</span>
                                @else
                                    <span class="badge-role-user">Estudiante</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('profile.index') }}" class="btn-action">
                                        👁️ Ver
                                    </a>
                                    @if((string)$usr->_id !== (string)auth()->id())
                                        <form action="#" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action" style="color: #991b1b; background-color: #fee2e2; border-color: #f8d7da;">
                                                🗑️
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <h3 style="color: #bd6464; margin-top: 0;">No hay usuarios registrados</h3>
                                    <p style="color: #6b7280; margin: 0;">Los nuevos registros de la comunidad aparecerán en este listado.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
