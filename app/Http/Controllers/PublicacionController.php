<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Validation\ValidationException;

class PublicacionController extends Controller
{
    public function consultar(Request $request){
        //Publicaciones no ocultas ordenadas por la fecha más reciente
        try{
            $query = Publicacion::where('oculta', false);

            //busqueda por nombre
            if($request->filled('buscar')){
                $query->where('titulo', 'like', '%' .$request->buscar . '%');
            }

            //busca por categoría
            if ($request->filled('categoria_id')) {
                $query->where('categoria_id', $request->categoria_id);
            }

            //filtrar por precio (mínimo y máximo) OPCIONAL SI MAU LO IMPLEMENTA
            if ($request->filled('precio_min')) {
                $query->where('precio', '>=', (float) $request->precio_min);
            }
            if ($request->filled('precio_max')) {
                $query->where('precio', '<=', (float) $request->precio_max);
            }

            // ordenar por precio (ascendente o descendente)
            if ($request->filled('orden_precio') && in_array($request->orden_precio, ['asc', 'desc'])) {
                $query->orderBy('precio', $request->orden_precio);
            } else {
                $query->orderBy('created_at', 'desc');
            }

            //consulta final en MongoDB Atlas
            $publicaciones = $query->get();

            return view('publications.index');

        } catch(\Exception $e){
            return view('publications.index', 500);
        }
    }

    public function crear(Request $request){
        try{
            // validaciones
            $request->validate([
                'titulo'    => 'required|string|max:100',
                'precio'    => 'required|numeric|min:0',
                'descripcion' => 'required|string',
                'categoria_id'=> 'required|string',
                'foto'      => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            //PROCESAR FOTOGRAFÍAS
            $rutaFoto = null;
            if($request->hasFile('foto')){
                //la foto se guarda en la carpeta storage/app/public/productos
                $rutaFoto = $request->file('foto')->store('productos', 'public');
            }

            // crwación
            $publicacion = new Publicacion();
            $publicacion->titulo = $request->titulo;
            $publicacion->precio = $request->precio;
            $publicacion->descripcion = $request->descripcion;
            $publicacion->categoria_id = $request->categoria_id;

            //la ruta de la imagen se guarda en MongoDB
            $publicacion->fotos = $rutaFoto;

            //asignación del usuario desde su sesión activa
            $publicacion->usuario_id = auth()->user()->id;

            $publicacion->estado = 'disponible';
            $publicacion->oculta = false;
            $publicacion->save();

            return response()->json([
                'estado' => 'Éxito',
                'mensaje' => 'Producto publicado.'
            ]);

        } catch(ValidationException $e){
            return response()->json([
                'estado' => 'Error de validación',
                'detalles' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'mensaje' => 'No se pudo guardar.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    //cambiar el estatus de una publicación y/o datos
    public function actualizar(Request $request, $id){
        try{
            $publicacion = Publicacion::find($id);

            if(!$publicacion){
                return respose()->json([
                    'estado'    => 'Error',
                    'mensaje'   => 'Publicación no encontrada.'
                ], 404);
            }

            if($request->usuario_id != $publicacion->usuario_id){
                return response()->json([
                    'estado'    => 'Denegado',
                    'mensaje'   => 'Permiso denegado, esta publicación no te pertenece.'
                ], 403);
            }

            //cambio de estado de publicación
            $publicacion->estado = $request->estado ?? $publicacion->estado;
            $publicacion->save();

            return response()->json([
                'estado'    => 'Éxito',
                'mensaje'   => 'Publicación actualizada exitosamente.'
            ]);
        } catch(\Exception $e){
            return response()->json([
                'estado'    => 'Error',
                'mensaje'   => 'Error al actualizar'
            ], 500);
        }
    }

    public function eliminar(Request $request, $id){
        try{
            $publicacion = Publicacion::find($id);

            //verifica si existe
            if(!$publicacion){
                return response()->json([
                    'estado'    => 'Error',
                    'mensaje'   => 'El producto no existe.'
                ], 404);
            }

            //solo el propietario puede eliminar su publicación
            if($request->usuario_id != $publicacion->usuario_id){
                return response()->json([
                    'estado'    => 'Denegado',
                    'mensaje'   => 'Solo el propietario puede eliminar su propia publicación.'
                ], 403);
            }

            $publicacion->delete();
            return response()->json([
                'estado'    => 'Éxito',
                'mensaje'   => 'Publicación eliminada correctamente'
            ]);

        } catch(\Exception $e){
            return response()->json([
                'estado'    => 'Error',
                'mensaje'   => 'Error al intentar eliminar la publicación'
            ], 500);
        }
    }
}
