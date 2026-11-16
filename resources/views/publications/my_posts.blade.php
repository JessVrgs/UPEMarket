<x-layout title="UPEMARKET | MIS PUBLICACIONES">
    <style>
        .my-publications-container {
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

        /* Cuadrícula de Artículos */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
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
            border: 1px solid #f3f4f6;
            position: relative;
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

        .product-status {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #16a34a;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .product-status.paused {
            background: #ca8a04;
        }

        .product-info {
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .product-category {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
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

        .product-actions {
            padding: 12px 15px;
            background-color: #f9fafb;
            border-top: 1px solid #f3f4f6;
            display: flex;
            gap: 10px;
        }

        .btn-action-card {
            flex: 1;
            padding: 8px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            transition: all 0.2s;
        }

        .btn-action-card:hover {
            background-color: #f3f4f6;
            border-color: #bd6464;
            color: #bd6464;
        }

        .btn-delete {
            color: #dc2626;
            border-color: #f8d7da;
            background-color: #fff5f5;
        }

        .btn-delete:hover {
            background-color: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        .empty-state {
            background: white;
            padding: 50px 20px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            grid-column: 1 / -1;
        }
    </style>

    <div class="my-publications-container">
        <!-- Encabezado de la sección -->
        <div class="page-header">
            <div>
                <h1>Mis Publicaciones</h1>
                <p>Administra, edita o elimina los artículos que has ofrecido en la comunidad UPEMOR</p>
            </div>
            <a href="{{ route('publications.create') }}" class="btn-primary-custom">
                <span>➕</span> Publicar Nuevo Artículo
            </a>
        </div>

        @php
            // Filtramos las publicaciones obtenidas en el controlador pertenecientes únicamente al usuario logueado
            $misPublicaciones = \App\Models\Publicacion::where('usuario_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        @endphp

            <!-- Cuadrícula de Artículos del Usuario -->
        <div class="products-grid">
            @forelse($misPublicaciones as $pub)
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="{{ $pub->foto ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=500&q=80' }}" alt="{{ $pub->titulo }}">
                        <span class="product-price">${{ number_format($pub->precio ?? 0, 2) }}</span>
                        <span class="product-status {{ $pub->estado === 'pausado' ? 'paused' : '' }}">
                            {{ $pub->estado ?? 'disponible' }}
                        </span>
                    </div>

                    <div class="product-info">
                        <span class="product-category">{{ $pub->categoria_id ?? 'General' }}</span>
                        <h3 class="product-title">{{ $pub->titulo ?? 'Sin título' }}</h3>
                        <p style="font-size: 12px; color: #6b7280; margin: 0;">Publicado el {{ $pub->created_at?->format('d/m/Y') ?? 'Reciente' }}</p>
                    </div>

                    <!-- Botones de Gestión -->
                    <div class="product-actions">
                        <a href="{{ route('publications.show', $pub->_id ?? $pub->id) }}" class="btn-action-card">
                            👁️ Ver
                        </a>

                        <form action="{{ url('/publicaciones/' . ($pub->_id ?? $pub->id)) }}" method="POST" style="flex: 1; margin: 0;" onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-card btn-delete" style="width: 100%;">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <h3 style="color: #bd6464; margin-top: 0;">No tienes publicaciones registradas</h3>
                    <p style="color: #4b5563; margin-bottom: 20px;">Aún no has puesto a la venta ningún artículo o servicio en UPEMarket.</p>
                    <a href="{{ route('publications.create') }}" class="btn-primary-custom">Publicar mi primer artículo</a>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
