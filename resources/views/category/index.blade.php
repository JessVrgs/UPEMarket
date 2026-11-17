<x-layout title="UPEMARKET | CATEGORÍAS">
    <style>
        .categories-container {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            flex: 1;
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

        .btn-action {
            background-color: #bd6464;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn-action:hover {
            background-color: #a55353;
        }

        /* Grid de publicaciones */
        .publications-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .pub-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #f3f4f6;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s;
        }

        .pub-card:hover {
            transform: translateY(-4px);
        }

        .pub-img {
            height: 180px;
            width: 100%;
            object-fit: cover;
            background-color: #1f2937;
        }

        .pub-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
            justify-content: space-between;
        }

        .pub-category {
            font-size: 11px;
            font-weight: 700;
            color: #bd6464;
            text-transform: uppercase;
            background: #fdf2f2;
            padding: 3px 10px;
            border-radius: 20px;
            width: fit-content;
            margin-bottom: 8px;
        }

        .pub-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 8px 0;
        }

        .pub-price {
            font-size: 20px;
            font-weight: 800;
            color: #bd6464;
            margin-bottom: 15px;
        }

        .btn-detail {
            background-color: #1f2937;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn-detail:hover {
            background-color: #374151;
        }

        .empty-state {
            background: white;
            padding: 50px 20px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
    </style>

    <div class="categories-container">
        <!-- Encabezado -->
        <div class="page-header">
            <div>
                <h1>Explorar por Categorías</h1>
                <p>Encuentra artículos organizados por sección dentro de la comunidad UPEMOR</p>
            </div>
            <a href="{{ route('publications.create') }}" class="btn-action">+ Vender Artículo</a>
        </div>

        @if(isset($publicaciones) && $publicaciones->count() > 0)
            <div class="publications-grid">
                @foreach($publicaciones as $pub)
                    <div class="pub-card">
                        <img src="{{ $pub->foto ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $pub->titulo }}" class="pub-img">
                        <div class="pub-content">
                            <div>
                                <span class="pub-category">{{ $pub->categoria_id ?? 'General' }}</span>
                                <h3 class="pub-title">{{ $pub->titulo }}</h3>
                                <div class="pub-price">${{ number_format($pub->precio, 2) }} MXN</div>
                            </div>
                            <a href="{{ route('publications.show', $pub->_id ?? $pub->id) }}" class="btn-detail">Ver Detalle</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3 style="color: #bd6464; margin-top: 0;">Aún no hay publicaciones disponibles</h3>
                <p style="color: #4b5563; margin-bottom: 20px;">Cuando los estudiantes publiquen productos, aparecerán aquí agrupados automáticamente.</p>
                <a href="{{ route('publications.create') }}" class="btn-action">Publicar el primer artículo</a>
            </div>
        @endif
    </div>
</x-layout>
