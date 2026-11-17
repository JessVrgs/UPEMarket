<x-layout title="UPEMARKET | CHAT PRIVADO">
    <style>
        .private-chat-container {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .chat-header-card {
            background: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f3f4f6;
            border-left: 5px solid #bd6464;
        }

        .chat-body-card {
            background: #f9fafb;
            padding: 20px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            min-height: 400px;
            max-height: 500px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            border: 1px solid #f3f4f6;
            border-top: none;
        }

        .bubble {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.5;
            position: relative;
            word-break: break-word;
        }

        .bubble.incoming {
            background: white;
            color: #1f2937;
            align-self: flex-start;
            border: 1px solid #e5e7eb;
            border-top-left-radius: 2px;
        }

        .bubble.outgoing {
            background: #bd6464;
            color: white;
            align-self: flex-end;
            border-top-right-radius: 2px;
        }

        .bubble-time {
            font-size: 10px;
            margin-top: 5px;
            text-align: right;
            opacity: 0.8;
        }

        .chat-footer-form {
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        .chat-footer-form textarea {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            resize: none;
            height: 40px;
            font-family: inherit;
            font-size: 14px;
        }

        .chat-footer-form textarea:focus {
            border-color: #bd6464;
        }

        .btn-send {
            background-color: #bd6464;
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-send:hover {
            background-color: #a55353;
        }
    </style>

    <div class="private-chat-container">
        <!-- Encabezado del Chat -->
        <div class="chat-header-card">
            <div>
                <a href="{{ route('mensajes.index') }}" style="color: #bd6464; text-decoration: none; font-weight: 600; font-size: 13px; display: inline-block; margin-bottom: 5px;">← Volver a la Bandeja</a>
                <h2 style="margin: 0; font-size: 18px; color: #1f2937;">Chat con {{ $otroUsuario?->nombre ?? $otroUsuario?->name ?? 'Estudiante' }}</h2>
                @if(isset($articulo) && $articulo)
                    <p style="margin: 3px 0 0 0; font-size: 13px; color: #6b7280;">Sobre el artículo: <a href="{{ route('publications.show', $articulo->_id ?? $articulo->id) }}" style="color: #bd6464; font-weight: 600; text-decoration: none;">{{ $articulo->titulo }}</a></p>
                @endif
            </div>
        </div>

        <!-- Cuerpo de Mensajes -->
        <div class="chat-body-card">
            @forelse($mensajesChat ?? [] as $msg)
                @php
                    $emisorId = is_array($msg) ? ($msg['emisor_id'] ?? '') : ($msg->emisor_id ?? '');
                    $textoMsg = is_array($msg) ? ($msg['texto'] ?? '') : ($msg->texto ?? $msg->mensaje ?? '');
                    $fechaMsg = is_array($msg) ? ($msg['fecha'] ?? '') : ($msg->fecha ?? '');
                    $esMio = (string) $emisorId === (string) auth()->id();
                @endphp
                <div class="bubble {{ $esMio ? 'outgoing' : 'incoming' }}">
                    {{ $textoMsg }}
                    <div class="bubble-time">{{ $fechaMsg }}</div>
                </div>
            @empty
                <div style="text-align: center; color: #6b7280; margin: auto;">
                    <p>No hay mensajes en esta conversación aún. ¡Escribe el primero!</p>
                </div>
            @endforelse
        </div>

        <!-- Formulario para responder en el chat -->
        <form action="{{ route('mensajes.enviar') }}" method="POST" class="chat-footer-form">
            @csrf
            <input type="hidden" name="conversacion_id" value="{{ $conversacion->_id ?? $conversacion->id }}">
            <input type="hidden" name="publicacion_id" value="{{ $articulo?->_id ?? $articulo?->id }}">
            <textarea name="mensaje" placeholder="Escribe un mensaje..." required></textarea>
            <button type="submit" class="btn-send">Enviar</button>
        </form>
    </div>
</x-layout>