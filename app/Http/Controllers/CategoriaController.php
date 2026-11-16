<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function consultar(){
        try{
            $categorias = Categoria::orderBy('nombre', 'asc')->get();

            return view('category.index');
        } catch(\Exception $e){
            return response()->json([
                'estado'    => 'Error',
                'mensaje'   => 'No se pudieron cargar las categorías',
                'detalle'   => $e->getMessage()
            ], 500);
        }
    }
}
