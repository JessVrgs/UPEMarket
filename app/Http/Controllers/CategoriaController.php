<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;

class CategoriaController extends Controller
{
    // El método debe llamarse 'consultar' tal como lo pide la ruta actual
    public function consultar(Request $request)
    {
        $categoriaSeleccionada = $request->get('categoria');

        if ($categoriaSeleccionada) {
            $publicaciones = Publicacion::where('categoria_id', $categoriaSeleccionada)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Trae todas las publicaciones para mostrarlas en la vista de categorías
            $publicaciones = Publicacion::orderBy('created_at', 'desc')->get();
        }

        return view('category.index', compact('publicaciones', 'categoriaSeleccionada'));
    }
}
