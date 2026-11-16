<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversacion;
use App\Models\Publicacion;

class ConversacionController extends Controller
{
    public function enviarMensajes(Request $request){
        try{
            $request->validate([
                'publicacion_id'    => 'required|string',
                'mensaje'           => 'required|string|max:500'
            ]);

            $publicacion = Publicacion::find($request->publicacion_id);

            if(!$publicacion){
                return response->json([
                    'estado'    => 'Error', 
                    'mensaje'   => 'La publicación no existe.'
                ], 404);
            }

            //no se pueden enviar mensajes a sí mismo
            $comprador_id = auth()->user()->id;
            if ($comprador_id == $publicacion->usuario_id) {
                return response()->json([
                    'estado' => 'Denegado', 
                    'mensaje' => 'No puedes enviarte un mensaje a ti mismo.'
                ], 403);
            }

            $conversacion = Conversacion::where('publicacion_id', $publicacion->id)
                ->where('comprador_id', $comprador_id)
                ->first();

            $nuevoMensaje = [
                'emisor_id' => $comprador_id,
                'texto'     => $request->mensaje,
                'fecha'     => now()
            ];

            if ($conversacion) {
                // Si ya existe, agregamos el nuevo mensaje al arreglo 
                $conversacion->push('mensajes', $nuevoMensaje);
            } else {
                // Si no existe, creamos la nueva conversación
                $conversacion = new Conversacion();
                $conversacion->publicacion_id = $publicacion->id;
                $conversacion->comprador_id = $comprador_id;
                $conversacion->vendedor_id = $publicacion->usuario_id;
                $conversacion->mensajes = [$nuevoMensaje]; // Inicia el arreglo de mensajes
                $conversacion->save();
            }

            return response()->json([
                'estado'    => 'Éxito',
                'mensaje'   => 'Mensaje enviado al vendedor'
            ]);
        } catch(\Exception $e){
            return response->json([
                'estado'    => 'Error',
                'mensaje'   => 'No se pudo enviar el mensaje'
            ], 500);
        }

    }

    //BANDEJA DE ENTRADA
    public function consultalConversacion(){
        try{
            $mi_id = auth()->user()->id;

            $conversaciones = Conversacion::where('comprador_id', $mi_id)
                ->orWhere('vendedor_id', $mi_id)
                ->with(['publicacion', 'comprador', 'vendedor']) // Trae los datos relacionados
                ->get();

            return response()->json([
                'estado' => 'Éxito', 
                'datos' => $conversaciones
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error', 
                'mensaje' => 'Error al cargar mensajes.'
            ], 500);
        }
    }
}
