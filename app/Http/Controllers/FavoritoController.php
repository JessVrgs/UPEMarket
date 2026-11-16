<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;
use App\Models\Publicacion;

class FavoritoController extends Controller
{
    public function agregarFavorito(Request $request){
        try{
            $request->validate([
                'publicacion_id' => 'required|string'
            ]);

            $usuario_id = auth()->user()->id;

            if (!Publicacion::find($request->publicacion_id)) {
                return response()->json([
                    'estado' => 'Error', 
                    'mensaje' => 'La publicación no existe.'
                ], 404);
            }

            //evitar duplicar un favorito
            $existe = Favorito::where('usuario_id', $usuario_id)
                ->where('publicacion_id', $request->publicacion_id)
                ->first();

            if ($existe) {
                return response()->json([
                    'estado' => 'Advertencia', 
                    'mensaje' => 'Ya tienes este producto en favoritos.'
                ]);
            }

            $favorito = new Favorito();
            $favorito->usuario_id = $usuario_id;
            $favorito->publicacion_id = $request->publicacion_id;
            $favorito->save();

            return response()->json([
                'estado' => 'Éxito', 
                'mensaje' => 'Guardado en favoritos.'
            ]);
        } catch(\Exception $e){
            return response()->json([
                'estado'    => 'Error',
                'mensaje'   => 'NO se pudo guardar'
            ], 500);
        }
    }

    public function consultarFavoritos() {
        try {
            $usuario_id = auth()->user()->id;

            $favoritos = Favorito::where('usuario_id', $usuario_id)
                ->with('publicacion')
                ->get();

            return response()->json([
                'estado' => 'Éxito', 
                'datos' => $favoritos
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error', 
                'mensaje' => 'Error al cargar favoritos.'
            ], 500);
        }
    }

    public function eliminarFavorito($publicacion_id) {
        try {
            $usuario_id = auth()->user()->id;

            $favorito = Favorito::where('usuario_id', $usuario_id)
                ->where('publicacion_id', $publicacion_id)
                ->first();

            if ($favorito) {
                $favorito->delete();
                return response()->json([
                    'estado' => 'Éxito', 
                    'mensaje' => 'Eliminado de favoritos.'
                ]);
            }

            return response()->json([
                'estado' => 'Error', 
                'mensaje' => 'No se encontró en favoritos.'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error', 
                'mensaje' => 'Error al eliminar.'
            ], 500);
        }
    }
}
