<x-layout title="UPEMARKET | CATEGORIAS">
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
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
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

        .btn-primary-custom {
            background-color: #bd6464;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-primary-custom:hover {
            background-color: #a55353;
        }

        /* Sección de cada Categoría */
        .category-section {
            margin-bottom: 40px;
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .category-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .category-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
        }

        .category-badge {
            background-color: #fdf2f2;
            color: #bd6464;
            border: 1px solid #f8d7da;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .view-all-link {
            color: #bd6464;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .view-all-link:hover {
            color: #9b4848;
            text-decoration: underline;
        }

        /* Cuadrícula de Artículos */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
            border: 1px solid #f3f4f6;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.1);
        }

        .product-image-container {
            width: 100%;
            height: 180px;
            background-color: #e5e7eb;
            position: relative;
            overflow: hidden;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-price {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
        }

        .product-info {
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .product-title {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-description {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-location {
            font-size: 12px;
            color: #4b5563;
            margin-top: auto;
            padding-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
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
        <!-- Encabezado de la sección -->
        <div class="page-header">
            <div>
                <h1>Explorar por Categorías</h1>
                <p>Encuentra artículos organizados por sección dentro de la comunidad UPEMOR</p>
            </div>
            <a href="{{ route('publications.create') }}" class="btn-primary-custom">
                <span>➕</span> Vender Artículo
            </a>
        </div>

        @php
            // Agrupamos la colección de publicaciones por su campo 'categoria_id'
            $grupos = collect($publicaciones ?? [])->groupBy(function($item) {
                return $item->categoria_id ?: 'General';
            });
        @endphp

        @forelse($grupos as $categoria => $articulos)
            <section class="category-section">
                <!-- Título de la categoría y contador -->
                <div class="category-header">
                    <div class="category-title-group">
                        <h2 class="category-title">{{ $categoria }}</h2>
                        <span class="category-badge">{{ $articulos->count() }} {{ $articulos->count() === 1 ? 'artículo' : 'artículos' }}</span>
                    </div>
                    <a href="{{ url('/publicaciones?categoria_id=' . urlencode($categoria)) }}" class="view-all-link">
                        Filtrar esta categoría →
                    </a>
                </div>

                <!-- Cuadrícula con los artículos pertenecientes a esta categoría -->
                <div class="products-grid">
                    @foreach($articulos as $pub)
                        <div class="product-card">
                            <div class="product-image-container">
                                <img src="{{ $pub->foto ?? $pub->imagen ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=500&q=80' }}" alt="{{ $pub->titulo }}">
                                <span class="product-price">${{ number_format($pub->precio ?? 0, 2) }}</span>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title">{{ $pub->titulo ?? 'Sin título' }}</h3>
                                <p class="product-description">{{ $pub->descripcion ?? 'Sin descripción detallada.' }}</p>
                                <p class="product-location">📍 Comunidad UPEMOR</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @empty
            <div class="empty-state">
                <h3 style="color: #bd6464; margin-top: 0;">Aún no hay categorías con artículos</h3>
                <p style="color: #4b5563; margin-bottom: 20px;">Cuando los estudiantes publiquen productos, aparecerán aquí agrupados automáticamente por categoría.</p>
                <a href="{{ route('publications.create') }}" class="btn-primary-custom">Publicar el primer artículo</a>
            </div>
        @endforelse
    </div>
</x-layout>
