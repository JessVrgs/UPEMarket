<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;

class CategoriaController extends Controller
{
    public function consultar(Request $request)
    {
        $categoriaSeleccionada = $request->get('categoria');

        if ($categoriaSeleccionada) {
            $publicaciones = Publicacion::where('categoria_id', $categoriaSeleccionada)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $publicaciones = Publicacion::orderBy('created_at', 'desc')->get();
        }

        return view('category.index', compact('publicaciones', 'categoriaSeleccionada'));
    }
}
