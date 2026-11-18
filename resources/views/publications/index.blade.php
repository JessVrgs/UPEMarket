<x-layout title="UPEMARKET | PUBLICACIONES">
    <style>
        .marketplace-container {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            flex: 1;
        }

        /* Barra de Filtros y Búsqueda estilo Marketplace */
        .filter-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-bar .search-input {
            flex: 1;
            min-width: 250px;
            padding: 10px 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
            background-color: white;
        }

        .filter-bar .search-input:focus {
            border-color: #bd6464;
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
            height: 41px;
            box-sizing: border-box;
        }

        .btn-primary-custom:hover {
            background-color: #a55353;
        }

        .btn-search {
            background-color: #1f2937;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            height: 41px;
        }

        .btn-search:hover {
            background-color: #374151;
        }

        /* Cuadrícula de Publicaciones estilo Facebook Marketplace */
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

        .product-category {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
        }

        .product-location {
            font-size: 13px;
            color: #4b5563;
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .empty-state {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            grid-column: 1 / -1;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 250px;
            display: flex;
            align-items: center;
        }

        .search-wrapper .search-input {
            width: 100%;
            padding-right: 36px; /* Espacio para que el texto no choque con la X */
        }

        .clear-input-btn {
            position: absolute;
            right: 10px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            line-height: 1;
            padding: 4px;
            border-radius: 50%;
            transition: color 0.2s, background-color 0.2s;
        }

        .clear-input-btn:hover {
            color: #1f2937;
            background-color: #f3f4f6;
        }

        .fav-btn-card {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.92);
            border: none;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            color: #f59e0b;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            transition: transform 0.15s;
            z-index: 5;
        }

        .fav-btn-card:hover {
            transform: scale(1.12);
        }

        .product-status {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #16a34a;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-status.paused {
            background: #ca8a04;
        }
    </style>

    <div class="marketplace-container">

        <!-- Barra de Búsqueda y Filtros Funcional -->
        <div class="filter-bar">
            <form action="{{ url('/publicaciones') }}" method="GET" class="filter-form">

                <!-- Input de búsqueda por título con X interna -->
                <div class="search-wrapper">
                    <input type="text" name="buscar" class="search-input" value="{{ request('buscar') }}" placeholder="Buscar productos en UPEMarket...">
                    @if(request()->filled('buscar'))
                        <a href="{{ url('/publicaciones') . (request()->filled('categoria_id') ? '?categoria_id=' . urlencode(request('categoria_id')) : '') }}" class="clear-input-btn" title="Limpiar búsqueda">&times;</a>
                    @endif
                </div>
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <!-- Selector de categorías -->
                    <select id="categoria_id" name="categoria_id">
                            <option value="">Selecciona una categoría</option>
                            <option value="Tecnología" {{ old('categoria_id') == 'Tecnología' ? 'selected' : '' }}>Tecnología / Electrónica</option>
                            <option value="Libros" {{ old('categoria_id') == 'Libros' ? 'selected' : '' }}>Libros</option>
                            <option value="Ropa" {{ old('categoria_id') == 'Ropa' ? 'selected' : '' }}>Ropa</option>
                            {{-- belleza y cuidado personal --}}
                            <option value="Belleza" {{ old('categoria_id') == 'Belleza' ? 'selected' : '' }}>Belleza y Cuidado Personal</option>
                            {{-- servicios --}}
                            <option value="Servicios" {{ old('categoria_id') == 'Servicios' ? 'selected' : '' }}>Servicios </option>
                            {{-- comida --}}
                            <option value="Comida" {{ old('categoria_id') == 'Comida' ? 'selected' : '' }}>Comida y Bebidas</option>
                            <option value="Otros" {{ old('categoria_id') == 'Otros' ? 'selected' : '' }}>Otros</option>
                    </select>

                    <button type="submit" class="btn-search">🔍 Buscar</button>
                </div>
            </form>
        </div>

        <!-- Cuadrícula de Artículos -->
        <div class="products-grid">

            @php
                $misFavoritosIds = \App\Models\Favorito::where('usuario_id', (string) auth()->id())
                    ->pluck('publicacion_id')
                    ->toArray();
            @endphp

            @forelse($publicaciones ?? [] as $pub)
                @php
                    $pubId = (string) ($pub->_id ?? $pub->id);
                    $esFavorito = in_array($pubId, $misFavoritosIds);
                @endphp

                <div class="product-card" style="position: relative;">
                    <form action="{{ route('favorites.toggle', $pubId) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="fav-btn-card" title="{{ $esFavorito ? 'Quitar de favoritos' : 'Guardar en favoritos' }}">
                            {{ $esFavorito ? '⭐' : '☆' }}
                        </button>
                    </form>

                    <a href="{{ route('publications.show', $pubId) }}" class="product-card" style="border: none; box-shadow: none;">
                        <div class="product-image-container">
                            <img src="{{ $pub->foto ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=500&q=80' }}" alt="Producto">
                            <span class="product-price">${{ number_format($pub->precio ?? 0, 2) }}</span>
                            <span class="product-status {{ $pub->estado === 'pausado' ? 'paused' : '' }}">
                                {{ $pub->estado ?? 'disponible' }}
                            </span>
                        </div>
                        <div class="product-info">
                            <span class="product-category">{{ $pub->categoria_id ?? 'General' }}</span>
                            <h3 class="product-title">{{ $pub->titulo ?? 'Sin título' }}</h3>
                            <p class="product-location">📅 {{ $pub->created_at ? $pub->created_at->setTimezone('America/Mexico_City')->format('d/m/Y h:i A') : 'Reciente' }}</p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="empty-state">
                    @if(request()->filled('buscar') || request()->filled('categoria_id'))
                        <h3 style="color: #bd6464; margin-top: 0;">No se encontraron resultados</h3>
                        <p style="color: #4b5563; margin-bottom: 15px;">Intenta con otra palabra clave o limpia los filtros para ver todo el catálogo.</p>
                        <a href="{{ url('/publicaciones') }}" class="btn-primary-custom">Ver todas las publicaciones</a>
                    @else
                        <h3 style="color: #bd6464; margin-top: 0;">No hay publicaciones disponibles</h3>
                        <p style="color: #4b5563; margin-bottom: 0;">¡Sé el primero en ofrecer un producto o servicio a la comunidad estudiantil!</p>
                    @endif
                </div>
            @endforelse

        </div>
    </div>
</x-layout>
