<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Validation\ValidationException;

class PublicacionController extends Controller
{
    public function consultar(){
        //Publicaciones no ocultas ordenadas por la fecha más reciente
        try{
            $publicaciones = Publicacion::where('oculta', false)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'estado' => 'Éxito',
                'datos'  => $publicaciones
            ]);
        } catch(\Exception $e){
            return response()->json([
                'estado'    => 'Error', 
                'mensaje'   => 'Error al cargar las publicaciones'
            ], 500);
        }
    }

    public function crear(Request $request){
        try{
            // validaciones
            $request->validate([
                'titulo'    => 'required|string|max:100',
                'precio'    => 'required|numeric|min:0',
                'descripcion' => 'required|string',
                'categoria_id'=> 'required|string'
            ]);

            // crwación 
            $publicacion = new Publicacion();
            $publicacion->titulo = $request->titulo;
            $publicacion->precio = $request->precio;
            $publicacion->descripcion = $request->descripcion;
            $publicacion->categoria_id = $request->categoria_id;

            //CAMBIAR AL CONECTAR EL LOGIN
            $publicacion->usuario_id = $request->usuario_id ?? 'usuario_simulado_124';

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
}
