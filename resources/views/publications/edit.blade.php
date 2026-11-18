<x-layout title="UPEMARKET | EDITAR ARTICULO">
    <style>
        .form-container {
            position: relative;
            z-index: 2;
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            flex: 1;
        }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
        }

        .form-card h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #1f2937;
            font-size: 24px;
            text-align: center;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 15px;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 15px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background-color: #f9fafb;
            color: #1f2937;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #bd6464;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(189, 100, 100, 0.15);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 140px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .current-image-preview {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 12px;
            background: #f9fafb;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .current-image-preview img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        .file-upload-box {
            border: 3px dashed #d1d5db;
            padding: 30px 20px;
            text-align: center;
            border-radius: 12px;
            background-color: #f9fafb;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .file-upload-box:hover {
            border-color: #bd6464;
            background-color: #fdf8f8;
        }

        .btn-submit {
            width: 100%;
            background-color: #bd6464;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #a55353;
        }

        .btn-cancel {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-cancel:hover {
            color: #1f2937;
            text-decoration: underline;
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>

    <div class="form-container">
        <div class="form-card">
            <h2>Editar Artículo</h2>

            <!-- Formulario apuntando a PUT /publicaciones/{id} con soporte para archivos -->
            <form action="{{ url('/publicaciones/' . ($publicacion->_id ?? $publicacion->id)) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="titulo">Título del Producto o Servicio</label>
                    <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $publicacion->titulo) }}" required>
                    @error('titulo')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="precio">Precio ($ MXN)</label>
                        <input type="number" step="0.01" min="0" id="precio" name="precio" value="{{ old('precio', $publicacion->precio) }}" required>
                        @error('precio')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="categoria_id">Categoría</label>
                        <select id="categoria_id" name="categoria_id" required>
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id ?? $cat->_id }}" 
                                    {{ old('categoria_id', $publicacion->categoria_id) == ($cat->id ?? $cat->_id) ? 'selected' : '' }}>
                                    {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="estado">Estatus del Artículo</label>
                        <select id="estado" name="estado" required>
                            <option value="disponible" {{ old('estado', $publicacion->estado) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="pausado" {{ old('estado', $publicacion->estado) == 'pausado' ? 'selected' : '' }}>Pausado / Vendido</option>
                        </select>
                        @error('estado')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción detallada</label>
                    <textarea id="descripcion" name="descripcion" required>{{ old('descripcion', $publicacion->descripcion) }}</textarea>
                    @error('descripcion')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto">Fotografía del Artículo (Opcional)</label>

                    @if(!empty($publicacion->foto))
                        <div class="current-image-preview">
                            <img src="{{ $publicacion->foto }}" alt="Imagen actual">
                            <span style="font-size: 13px; color: #4b5563;">Imagen actual guardada. Si seleccionas un nuevo archivo, este se reemplazará.</span>
                        </div>
                    @endif

                    <div class="file-upload-box" onclick="document.getElementById('foto').click()">
                        <span style="font-size: 30px; display: block; margin-bottom: 8px;">📷</span>
                        <span style="font-size: 14px; color: #4b5563; font-weight: 500;" id="file-label">Haz clic para cambiar la imagen (PNG, JPG)</span>
                        <input type="file" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg" style="display: none;" onchange="updateFileName(this)">
                    </div>
                    @error('foto')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Guardar Cambios</button>
                <a href="{{ route('publications.my_posts') }}" class="btn-cancel">Cancelar y volver</a>
            </form>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const label = document.getElementById('file-label');
            if (input.files && input.files[0]) {
                label.textContent = "✔ Nuevo archivo seleccionado: " + input.files[0].name;
                label.style.color = "#bd6464";
                label.style.fontWeight = "700";
            }
        }
    </script>
</x-layout>
