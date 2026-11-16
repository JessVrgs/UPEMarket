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
            margin-bottom: 25px;
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

        .btn-contact {
            background-color: #bd6464;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: background 0.2s;
        }

        .btn-contact:hover {
            background-color: #a55353;
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

                    <div class="section-box">
                        <h4>Descripción del Artículo</h4>
                        <p>{{ $publicacion->descripcion }}</p>
                    </div>

                    <div class="section-box">
                        <h4>Lugar de Entrega</h4>
                        <p>📍 Instalaciones de la Universidad Politécnica del Estado de Morelos (UPEMOR)</p>
                    </div>

                    <!-- Datos del Vendedor -->
                    <div class="seller-box">
                        <div class="seller-avatar">
                            {{ substr($publicacion->usuario?->nombre ?? 'U', 0, 1) }}
                        </div>
                        <div class="seller-info">
                            <h5>{{ $publicacion->usuario?->nombre ?? 'Estudiante UPEMOR' }}</h5>
                            <p>Carrera: {{ $publicacion->usuario?->carrera ?? 'Comunidad Estudiantil' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Botón de contacto / chat -->
                <a href="#" class="btn-contact" onclick="alert('Función de chat directo próximamente en UPEMarket'); return false;">
                    💬 Contactar al Vendedor
                </a>
            </div>
        </div>
    </div>
</x-layout>
