<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversacion;
use App\Models\Publicacion;

class ConversacionController extends Controller
{
    // 1. BANDEJA DE ENTRADA (Vista message.index)
    public function consultarConversacion()
    {
        try {
            $mi_id = (string) auth()->id();

            $conversaciones = Conversacion::where('comprador_id', $mi_id)
                ->orWhere('vendedor_id', $mi_id)
                ->with(['publicacion', 'comprador', 'vendedor'])
                ->orderBy('updated_at', 'desc')
                ->get();

            return view('message.index', compact('conversaciones'));

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar la bandeja de mensajes.');
        }
    }

    // 2. VER CHAT PRIVADO (Vista message.show)
    public function verChat($id)
    {
        try {
            $mi_id = (string) auth()->id();
            $conversacion = Conversacion::with(['publicacion', 'comprador', 'vendedor'])->findOrFail($id);

            // Seguridad: verificar que el usuario pertenezca a esta conversación
            if ((string) $conversacion->comprador_id !== $mi_id && (string) $conversacion->vendedor_id !== $mi_id) {
                return redirect()->route('mensajes.index');
            }

            $otroUsuario = ((string) $conversacion->comprador_id === $mi_id)
                ? $conversacion->vendedor
                : $conversacion->comprador;

            $articulo = $conversacion->publicacion;
            $mensajesChat = $conversacion->mensajes ?? [];

            return view('message.show', compact('conversacion', 'mensajesChat', 'otroUsuario', 'articulo'));

        } catch (\Exception $e) {
            return redirect()->route('mensajes.index')->with('error', 'No se pudo abrir la conversación.');
        }
    }

    // 3. ENVIAR MENSAJE (Desde el producto o desde el chat privado)
    public function enviarMensajes(Request $request)
    {
        try {
            $request->validate([
                'publicacion_id'  => 'required|string',
                'mensaje'         => 'required|string|max:500',
                'conversacion_id' => 'nullable|string'
            ]);

            $mi_id = (string) auth()->id();
            $publicacion = Publicacion::find($request->publicacion_id);

            if (!$publicacion) {
                return back()->with('error', 'La publicación no existe.');
            }

            $nuevoMensaje = [
                'emisor_id' => $mi_id,
                'texto'     => $request->mensaje,
                'fecha'     => now()->format('d/m/Y H:i')
            ];

            if ($request->filled('conversacion_id')) {
                $conversacion = Conversacion::findOrFail($request->conversacion_id);
                $conversacion->push('mensajes', $nuevoMensaje);
                $conversacion->touch(); 

                return redirect()->route('mensajes.chat', $conversacion->_id ?? $conversacion->id);
            }

            if ($mi_id === (string) $publicacion->usuario_id) {
                return back()->with('error', 'No puedes enviarte un mensaje a ti mismo.');
            }

            $conversacion = Conversacion::where('publicacion_id', (string) $publicacion->id)
                ->where('comprador_id', $mi_id)
                ->first();

            if ($conversacion) {
                $conversacion->push('mensajes', $nuevoMensaje);
                $conversacion->touch();
            } else {
                $conversacion = new Conversacion();
                $conversacion->publicacion_id = (string) $publicacion->id;
                $conversacion->comprador_id = $mi_id;
                $conversacion->vendedor_id = (string) $publicacion->usuario_id;
                $conversacion->mensajes = [$nuevoMensaje];
                $conversacion->save();
            }

            return redirect()->route('mensajes.chat', $conversacion->_id ?? $conversacion->id)
                ->with('success', '¡Mensaje enviado con éxito!');

        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo enviar el mensaje.');
        }
    }
}