<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Validation\ValidationException;

class PublicacionController extends Controller
{
    public function consultar(Request $request){
        try{
            $query = Publicacion::where('oculta', false);

            // Búsqueda por título
            if($request->filled('buscar')){
                $query->where('titulo', 'like', '%' . $request->buscar . '%');
            }

            // Búsqueda por categoría
            if ($request->filled('categoria_id')) {
                $query->where('categoria_id', $request->categoria_id);
            }

            // Filtrar por precio mínimo y máximo
            if ($request->filled('precio_min')) {
                $query->where('precio', '>=', (float) $request->precio_min);
            }
            if ($request->filled('precio_max')) {
                $query->where('precio', '<=', (float) $request->precio_max);
            }

            // Ordenar por precio o fecha
            if ($request->filled('orden_precio') && in_array($request->orden_precio, ['asc', 'desc'])) {
                $query->orderBy('precio', $request->orden_precio);
            } else {
                $query->orderBy('created_at', 'desc');
            }

            // Consulta final en MongoDB Atlas
            $publicaciones = $query->get();

            // Pasamos la variable $publicaciones a la vista para que el @forelse funcione
            return view('publications.index', compact('publicaciones'));

        } catch(\Exception $e){
            return view('publications.index', ['publicaciones' => collect()])->with('error', 'Error al cargar las publicaciones.');
        }
    }

    public function crear(Request $request){
        try{
            // Validaciones
            $request->validate([
                'titulo'        => 'required|string|max:100',
                'precio'        => 'required|numeric|min:0',
                'descripcion'   => 'required|string',
                'categoria_id'  => 'required|string',
                'foto'          => 'required|file|image|mimes:jpeg,png,jpg,webp|max:10240' // Subido a 10MB y flexible
            ]);

            // Procesar fotografía
            $rutaFoto = null;
            if($request->hasFile('foto')){
                // La foto se guarda en storage/app/public/productos
                $path = $request->file('foto')->store('productos', 'public');
                // Guardamos la ruta pública accesible (storage/productos/...)
                $rutaFoto = asset('storage/' . $path);
            }

            // Creación del registro
            $publicacion = new Publicacion();
            $publicacion->titulo = $request->titulo;
            $publicacion->precio = $request->precio;
            $publicacion->descripcion = $request->descripcion;
            $publicacion->categoria_id = $request->categoria_id;

            // Usamos 'foto' en singular para que coincida perfectamente
            $publicacion->foto = $rutaFoto;

            // Asignación del usuario desde su sesión activa
            $publicacion->usuario_id = auth()->id();

            $publicacion->estado = 'disponible';
            $publicacion->oculta = false;
            $publicacion->save();

            // Redirección exitosa de vuelta a la lista de publicaciones
            return redirect('/publicaciones')->with('success', '¡Artículo publicado con éxito!');

        } catch(ValidationException $e){
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo guardar: ' . $e->getMessage()])->withInput();
        }
    }

    public function mostrar($id)
    {
        try {
            $publicacion = Publicacion::with('usuario')->find($id);

            if (!$publicacion || $publicacion->oculta) {
                return redirect('/publicaciones')->with('error', 'La publicación no existe o ya no está disponible.');
            }

            return view('publications.show', compact('publicacion'));

        } catch (\Exception $e) {
            return redirect('/publicaciones')->with('error', 'Error al cargar los detalles del artículo.');
        }
    }

    // Cambiar el estatus de una publicación y/o datos
    public function editarFormulario($id)
    {
        $publicacion = \App\Models\Publicacion::find($id);

        if (!$publicacion || $publicacion->usuario_id !== auth()->id()) {
            return redirect('/mis-publicaciones')->with('error', 'No autorizado o publicación no encontrada.');
        }

        return view('publications.edit', compact('publicacion'));
    }

    public function actualizar(Request $request, $id)
    {
        $publicacion = Publicacion::find($id);

        if (!$publicacion || $publicacion->usuario_id !== auth()->id()) {
            return redirect('/mis-publicaciones')->with('error', 'Acción no autorizada.');
        }

        $request->validate([
            'titulo'       => 'required|string|max:100',
            'precio'       => 'required|numeric|min:0',
            'descripcion'  => 'required|string',
            'categoria_id' => 'required|string',
            'estado'       => 'required|string',
            'foto'         => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:10240'
        ]);

        $publicacion->titulo = $request->titulo;
        $publicacion->precio = $request->precio;
        $publicacion->descripcion = $request->descripcion;
        $publicacion->categoria_id = $request->categoria_id;
        $publicacion->estado = $request->estado;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('productos', 'public');
            $publicacion->foto = asset('storage/' . $path);
        }

        $publicacion->save();

        return redirect('/mis-publicaciones')->with('success', '¡Artículo actualizado con éxito!');
    }

    public function eliminar(Request $request, $id){
        try{
            $publicacion = Publicacion::find($id);

            if(!$publicacion){
                return response()->json([
                    'estado'    => 'Error',
                    'mensaje'   => 'El producto no existe.'
                ], 404);
            }

            if($request->user()->id != $publicacion->usuario_id){
                return response()->json([
                    'estado'    => 'Denegado',
                    'mensaje'   => 'Solo el propietario puede eliminar su propia publicación.'
                ], 403);
            }

            $publicacion->delete();
            return view('publications.my_posts');

        } catch(\Exception $e){
            return response()->json([
                'estado'    => 'Error',
                'mensaje'   => 'Error al intentar eliminar la publicación'
            ], 500);
        }
    }


}
