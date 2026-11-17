<x-layout title="UPEMARKET | CHAT">
    <style>
        .chat-container {
            position: relative;
            z-index: 2;
            max-width: 1000px;
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

        .messages-list-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border: 1px solid #f3f4f6;
            overflow: hidden;
        }

        .message-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s;
        }

        .message-card-link:last-child {
            border-bottom: none;
        }

        .message-card-link:hover {
            background-color: #f9fafb;
        }

        .message-item {
            padding: 20px 25px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .message-header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #6b7280;
            flex-wrap: wrap;
            gap: 10px;
        }

        .message-user {
            font-weight: 700;
            color: #1f2937;
            font-size: 15px;
        }

        .message-body {
            font-size: 15px;
            color: #374151;
            background: #fdf2f2;
            padding: 12px 16px;
            border-radius: 8px;
            border-left: 4px solid #bd6464;
            margin: 0;
            line-height: 1.5;
        }

        .message-body.sent {
            background: #f3f4f6;
            border-left: 4px solid #9ca3af;
        }

        .empty-state {
            background: white;
            padding: 50px 20px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
    </style>

    <div class="chat-container">
        <div class="page-header">
            <h1>Bandeja de Mensajes</h1>
            <p>Revisa las consultas y respuestas sobre los artículos en UPEMarket</p>
        </div>

        @if(session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 14px;">
                ✔ {{ session('success') }}
            </div>
        @endif

        <div class="messages-list-card">
            @forelse($mensajes ?? [] as $msg)
                @php
                    $esEmisor = (string) $msg->emisor_id === (string) auth()->id();
                    $otroUsuarioId = $esEmisor ? $msg->receptor_id : $msg->emisor_id;
                    $otroUsuario = \App\Models\User::find($otroUsuarioId);
                    $articulo = \App\Models\Publicacion::find($msg->publicacion_id);
                @endphp

                    <!-- Tarjeta completa como enlace estilo WhatsApp -->
                <a href="{{ route('mensajes.chat', $msg->_id ?? $msg->id) }}" class="message-card-link">
                    <div class="message-item">
                        <div class="message-header-info">
                            <div>
                                <span class="message-user">
                                    {{ $esEmisor ? 'Para: ' . ($otroUsuario?->nombre ?? $otroUsuario?->name ?? 'Usuario') : 'De: ' . ($otroUsuario?->nombre ?? $otroUsuario?->name ?? 'Usuario') }}
                                </span>
                                @if($articulo)
                                    <span style="margin-left: 10px; font-size: 13px; color: #bd6464; font-weight: 600;">
                                        📦 Artículo: {{ $articulo->titulo }}
                                    </span>
                                @endif
                            </div>
                            <span style="font-size: 12px;">{{ $msg->created_at?->format('d/m/Y H:i') ?? 'Reciente' }}</span>
                        </div>

                        <p class="message-body {{ $esEmisor ? 'sent' : '' }}">
                            {{ $msg->mensaje }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <h3 style="color: #bd6464; margin-top: 0;">No tienes mensajes en tu bandeja</h3>
                    <p style="color: #4b5563; margin-bottom: 20px;">Cuando otros estudiantes te pregunten por un artículo o tú contactes a un vendedor, aparecerán aquí.</p>
                    <a href="{{ url('/publicaciones') }}" style="background-color: #bd6464; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">
                        Explorar Marketplace
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
