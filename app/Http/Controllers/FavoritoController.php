<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;
use App\Models\Publicacion;

class FavoritoController extends Controller
{
    // Muestra la vista con todas las publicaciones favoritas del usuario
    public function index()
    {
        $usuarioId = (string) auth()->id();

        $favoritos = Favorito::where('usuario_id', $usuarioId)
            ->orderBy('created_at', 'desc')
            ->get();

        $publicacionIds = $favoritos->pluck('publicacion_id')->toArray();

        $publicaciones = Publicacion::whereIn('_id', $publicacionIds)
            ->where('oculta', false)
            ->get();

        return view('publications.favorites', compact('publicaciones'));
    }

    // Guarda o quita una publicación de favoritos al darle clic a la estrella
    public function toggle($publicacionId)
    {
        $usuarioId = (string) auth()->id();
        $pubId = (string) $publicacionId;

        if (!Publicacion::find($pubId)) {
            return back()->with('error', 'La publicación no existe.');
        }

        $existente = Favorito::where('usuario_id', $usuarioId)
            ->where('publicacion_id', $pubId)
            ->first();

        if ($existente) {
            $existente->delete();
            return back()->with('success', 'Eliminado de tus favoritos.');
        }

        Favorito::create([
            'usuario_id'     => $usuarioId,
            'publicacion_id' => $pubId,
        ]);

        return back()->with('success', '⭐ ¡Guardado en tus favoritos!');
    }
}