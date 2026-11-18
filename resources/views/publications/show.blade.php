<x-layout title="UPEMARKET | DETALLE DEL ARTÍCULO">
    <style>
        .detail-container {
            position: relative;
            z-index: 2;
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            flex: 1;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #4b5563;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #bd6464;
        }

        .detail-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.08);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            border: 1px solid #f3f4f6;
        }

        .detail-image-box {
            background-color: #1f2937;
            position: relative;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .detail-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .detail-info {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .category-tag {
            background-color: #fdf2f2;
            color: #bd6464;
            border: 1px solid #f8d7da;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 12px;
            width: fit-content;
        }

        .detail-title {
            font-size: 26px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px 0;
        }

        .detail-price {
            font-size: 28px;
            font-weight: 800;
            color: #bd6464;
            margin-bottom: 20px;
        }

        .section-box {
            margin-bottom: 20px;
        }

        .section-box h4 {
            margin: 0 0 6px 0;
            font-size: 14px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-box p {
            margin: 0;
            font-size: 15px;
            color: #374151;
            line-height: 1.6;
        }

        .seller-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .seller-avatar {
            background: #bd6464;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .seller-info h5 {
            margin: 0;
            font-size: 15px;
            color: #1f2937;
        }

        .seller-info p {
            margin: 2px 0 0 0;
            font-size: 13px;
            color: #6b7280;
        }

        /* Caja de mensajería interna */
        .internal-chat-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 20px;
            border-radius: 12px;
            margin-top: 15px;
        }

        .internal-chat-box h4 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .internal-chat-box textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            box-sizing: border-box;
            resize: vertical;
            min-height: 80px;
            outline: none;
            background-color: white;
            transition: border-color 0.2s;
        }

        .internal-chat-box textarea:focus {
            border-color: #bd6464;
            box-shadow: 0 0 0 2px rgba(189, 100, 100, 0.15);
        }

        .actions-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .btn-send-message {
            background-color: #bd6464;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-send-message:hover {
            background-color: #a55353;
        }

        .btn-whatsapp {
            background-color: #25d366;
        }

        .btn-whatsapp:hover {
            background-color: #1ebe5d;
        }

        @media (max-width: 768px) {
            .detail-card {
                grid-template-columns: 1fr;
            }
            .detail-image-box {
                min-height: 280px;
            }
            .detail-info {
                padding: 25px;
            }
        }
    </style>

    <div class="detail-container">
        <a href="{{ url('/publicaciones') }}" class="back-link">
            ← Volver al Marketplace
        </a>

        @if(session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 14px;">
                ✔ {{ session('success') }}
            </div>
        @endif

        <div class="detail-card">
            <!-- Imagen del producto -->
            <div class="detail-image-box">
                <img src="{{ $publicacion->foto ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $publicacion->titulo }}">
            </div>

            <!-- Información detallada -->
            <div class="detail-info">
                <div>
                    <span class="category-tag">{{ $publicacion->categoria_id ?? 'General' }}</span>
                    <h1 class="detail-title">{{ $publicacion->titulo }}</h1>
                    <div class="detail-price">${{ number_format($publicacion->precio, 2) }} MXN</div>

                    @php
                        $pubId = (string) ($publicacion->_id ?? $publicacion->id);
                        $esFavorito = \App\Models\Favorito::where('usuario_id', (string) auth()->id())
                            ->where('publicacion_id', $pubId)
                            ->exists();
                    @endphp

                    <form action="{{ route('favorites.toggle', $pubId) }}" method="POST" style="margin-bottom: 20px;">
                        @csrf
                        <button type="submit" style="background-color: {{ $esFavorito ? '#fef3c7' : '#f3f4f6' }}; color: {{ $esFavorito ? '#b45309' : '#374151' }}; border: 1px solid {{ $esFavorito ? '#fcd34d' : '#d1d5db' }}; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            {{ $esFavorito ? '⭐ Guardado en Favoritos' : '☆ Guardar en Favoritos' }}
                        </button>
                    </form>

                    <div class="section-box">
                        <h4>Descripción del Artículo</h4>
                        <p>{{ $publicacion->descripcion }}</p>
                    </div>

                    <div class="section-box">
                        <h4>Fecha de Publicación</h4>
                        <p>📅 {{ $publicacion->created_at ? $publicacion->created_at->setTimezone('America/Mexico_City')->locale('es')->isoFormat('D [de] MMMM [de] YYYY, h:mm A') : 'Fecha no disponible' }}</p>
                    </div>

                    @php
                        // Buscamos al usuario creador del artículo en la base de datos
                        $vendedor = \App\Models\User::find($publicacion->usuario_id);
                    @endphp

                        <!-- Datos del Vendedor -->
                    <div class="seller-box">
                        <div class="seller-avatar">
                            {{ substr($vendedor?->nombre ?? $vendedor?->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="seller-info">
                            <h5>{{ $vendedor?->nombre ?? $vendedor?->name ?? 'Estudiante UPEMOR' }}</h5>
                            <p>Comunidad Estudiantil UPEMOR</p>
                        </div>
                    </div>
                </div>

                <!-- Chat o formulario interno corregido -->
                <div class="internal-chat-box">
                    <h4>Preguntar al Vendedor</h4>

                    @if(auth()->id() !== $publicacion->usuario_id)
                        <form action="{{ route('mensajes.enviar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="receptor_id" value="{{ $publicacion->usuario_id }}">
                            <input type="hidden" name="publicacion_id" value="{{ $publicacion->_id ?? $publicacion->id }}">

                            <textarea name="mensaje" placeholder="Escribe tu duda sobre el precio, estado o entrega en la universidad..." required></textarea>

                            <div class="actions-container">
                                <button type="submit" class="btn-send-message">
                                    ✉️ Enviar Mensaje
                                </button>

                                @php
                                    // Preparamos el enlace de WhatsApp usando el teléfono del vendedor si está disponible
                                    $telefonoVendedor = $vendedor?->telefono ?? $vendedor?->phone ?? '7771101120';
                                    $textoWp = urlencode("Hola, me interesa tu artículo '{$publicacion->titulo}' publicado en UPEMarket.");
                                @endphp
                                <a href="https://wa.me/521{{ $telefonoVendedor }}?text={{ $textoWp }}" target="_blank" class="btn-send-message btn-whatsapp">
                                    💬 Enviar WhatsApp
                                </a>
                            </div>
                        </form>
                    @else
                        <p style="margin: 0; color: #6b7280; font-size: 13px;">Esta publicación es tuya, no puedes enviarte mensajes a ti mismo.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
