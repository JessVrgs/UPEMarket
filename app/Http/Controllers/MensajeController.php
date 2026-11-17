<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;

class MensajeController extends Controller
{
    // Método para enviar el mensaje desde la vista de detalle
    public function enviar(Request $request)
    {
        $request->validate([
            'receptor_id' => 'required',
            'publicacion_id' => 'required',
            'mensaje' => 'required|string|max:1000'
        ]);

        Mensaje::create([
            'emisor_id' => (string) auth()->id(),
            'receptor_id' => (string) $request->receptor_id,
            'publicacion_id' => (string) $request->publicacion_id,
            'mensaje' => $request->mensaje,
        ]);

        return redirect()->route('mensajes.index')->with('success', '¡Mensaje enviado con éxito!');
    }

    // Método para mostrar la bandeja de entrada agrupada estilo WhatsApp
    public function bandeja()
    {
        $userId = (string) auth()->id();

        // Traemos todos los mensajes ordenados del más reciente al más antiguo
        $todosLosMensajes = Mensaje::orderBy('created_at', 'desc')->get();

        // Filtramos en PHP para asegurar que el usuario actual participe (emisor o receptor)
        $mensajesUsuario = $todosLosMensajes->filter(function ($msg) use ($userId) {
            return (string) $msg->emisor_id === $userId || (string) $msg->receptor_id === $userId;
        });

        // Filtramos para conservar únicamente el mensaje más reciente por cada conversación única
        $vistos = [];
        $mensajesUnicos = $mensajesUsuario->filter(function ($msg) use ($userId, &$vistos) {
            $contraparte = ((string) $msg->emisor_id === $userId) ? (string) $msg->receptor_id : (string) $msg->emisor_id;
            $publicacionId = (string) $msg->publicacion_id;

            // Llave única para esta conversación (contraparte + artículo)
            $key = $contraparte . '-' . $publicacionId;

            if (!in_array($key, $vistos)) {
                $vistos[] = $key;
                return true; // Conservamos este porque es el más reciente de esta charla
            }

            return false; // Descartamos mensajes anteriores repetidos de la misma charla
        });

        return view('message.index', compact('mensajesUnicos'));
    }

    // Método para ver la conversación privada tipo WhatsApp
    public function chatPrivado($id)
    {
        $userId = (string) auth()->id();

        // Buscamos el mensaje seleccionado para obtener la contraparte y el artículo
        $mensajeActual = Mensaje::findOrFail($id);

        $otroUsuarioId = ((string) $mensajeActual->emisor_id === $userId)
            ? $mensajeActual->receptor_id
            : $mensajeActual->emisor_id;

        $otroUsuario = \App\Models\User::find($otroUsuarioId);
        $articulo = \App\Models\Publicacion::find($mensajeActual->publicacion_id);

        // Traemos todos los mensajes cruzados entre ambos usuarios para este artículo
        $todosLosMensajesChat = Mensaje::orderBy('created_at', 'asc')->get();

        $mensajesChat = $todosLosMensajesChat->filter(function ($msg) use ($userId, $otroUsuarioId, $mensajeActual) {
            $esDeEsteArticulo = (string) $msg->publicacion_id === (string) $mensajeActual->publicacion_id;

            $participanAmbos = (
                ((string) $msg->emisor_id === $userId && (string) $msg->receptor_id === $otroUsuarioId) ||
                ((string) $msg->emisor_id === $otroUsuarioId && (string) $msg->receptor_id === $userId)
            );
        });

        return view('message.show', compact('mensajesChat', 'otroUsuario', 'articulo'));
    }
}
