<x-layout title="UPEMARKET | MIS FAVORITOS">
    <style>
        .favorites-container {
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
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .page-header h2 {
            margin: 0;
            color: #1f2937;
            font-size: 22px;
        }

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
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.1);
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
            z-index: 5;
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

        .btn-primary-custom {
            background-color: #bd6464;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
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

    <div class="favorites-container">
        <div class="page-header">
            <h2>⭐ Mis Publicaciones Favoritas</h2>
            <span style="color: #6b7280; font-size: 14px;">{{ $publicaciones->count() }} artículo(s) guardado(s)</span>
        </div>

        @if(session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="products-grid">
            @forelse($publicaciones as $pub)
                @php $pubId = (string) ($pub->_id ?? $pub->id); @endphp
                <div class="product-card">
                    <form action="{{ route('favorites.toggle', $pubId) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="fav-btn-card" title="Quitar de favoritos">⭐</button>
                    </form>

                    <a href="{{ route('publications.show', $pubId) }}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; flex: 1;">
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
                    <h3 style="color: #bd6464; margin-top: 0;">Aún no tienes favoritos guardados</h3>
                    <p style="color: #4b5563; margin-bottom: 0;">Explora el catálogo y toca la estrella ☆ en los artículos que te interesen para verlos aquí después.</p>
                    <a href="{{ url('/publicaciones') }}" class="btn-primary-custom">Explorar Publicaciones</a>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>