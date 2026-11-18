<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Validation\ValidationException;
use App\Services\CloudinaryService;

class PublicacionController extends Controller
{
    public function consultar(Request $request)
    {
        try {
            $query = Publicacion::where('oculta', false);

            if ($request->filled('buscar')) {
                $query->where('titulo', 'like', '%' . $request->buscar . '%');
            }

            if ($request->filled('categoria_id')) {
                $query->where('categoria_id', $request->categoria_id);
            }

            if ($request->filled('precio_min')) {
                $query->where('precio', '>=', (float) $request->precio_min);
            }
            if ($request->filled('precio_max')) {
                $query->where('precio', '<=', (float) $request->precio_max);
            }

            if ($request->filled('orden_precio') && in_array($request->orden_precio, ['asc', 'desc'])) {
                $query->orderBy('precio', $request->orden_precio);
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $publicaciones = $query->get();

            return view('publications.index', compact('publicaciones'));

        } catch (\Exception $e) {
            return view('publications.index', ['publicaciones' => collect()])->with('error', 'Error al cargar las publicaciones.');
        }
    }

    public function crear(Request $request)
    {
        try {
            // 1. Definimos las reglas
            $reglas = [
                // \pL asegura que exista al menos una letra unicode (permite números y espacios mientras haya letras)
                'titulo'       => ['required', 'string', 'max:100', 'regex:/[\pL]/u'], 
                'precio'       => 'required|numeric|min:0',
                'descripcion'  => 'required|string',
                'categoria_id' => 'required|string',
                'foto'         => 'required|file|image|mimes:jpeg,png,jpg,webp|max:10240' 
            ];

            // 2. Definimos los mensajes de error personalizados
            $mensajes = [
                'titulo.regex' => 'El título no puede contener solo números, debe incluir letras.',
                'foto.image'   => 'Solo se aceptan imágenes y el archivo que quiere subir no es válido.',
                'foto.mimes'   => 'Solo se aceptan imágenes y el archivo que quiere subir no es válido.',
            ];

            // Pasamos ambos arreglos a la validación
            $request->validate($reglas, $mensajes);

            $rutaFoto = null;
            $fotoPublicId = null;
            if ($request->hasFile('foto')) {
                $subida = app(CloudinaryService::class)->subir($request->file('foto'));
                $rutaFoto = $subida['url'];
                $fotoPublicId = $subida['public_id'];
            }

            $publicacion = new Publicacion();
            $publicacion->titulo = $request->titulo;
            $publicacion->precio = $request->precio;
            $publicacion->descripcion = $request->descripcion;
            $publicacion->categoria_id = $request->categoria_id;
            $publicacion->foto = $rutaFoto;
            $publicacion->foto_public_id = $fotoPublicId;
            $publicacion->usuario_id = auth()->id();
            $publicacion->estado = 'disponible';
            $publicacion->oculta = false;
            $publicacion->save();

            return redirect('/publicaciones')->with('success', '¡Artículo publicado con éxito!');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo guardar: ' . $e->getMessage()])->withInput();
        }
    }

    public function mostrar($id)
    {
        try {
            $publicacion = Publicacion::with('usuario')->find($id);

            if (!$publicacion || $publicacion->oculta) {
                return redirect('/publicaciones')->with('error', 'La publicación no existe o ya no está disponible.');
            }

            return view('publications.show', compact('publicacion'));

        } catch (\Exception $e) {
            return redirect('/publicaciones')->with('error', 'Error al cargar los detalles del artículo.');
        }
    }

    public function editar($id)
    {
        try {
            $publicacion = Publicacion::findOrFail($id);

            $esDueno = (string) $publicacion->usuario_id === (string) auth()->id();
            $esAdmin = auth()->user()?->rol === 'admin';

            if (!$esDueno && !$esAdmin) {
                return redirect('/publicaciones')->with('error', 'No tienes permiso para editar esta publicación.');
            }

            $categorias = \App\Models\Categoria::all();

            return view('publications.edit', compact('publicacion', 'categorias'));

        } catch (\Exception $e) {
            return redirect('/publicaciones')->with('error', 'No se encontró la publicación solicitada.');
        }
    }

    public function actualizar(Request $request, $id)
    {
        $publicacion = Publicacion::find($id);

        if (!$publicacion || $publicacion->usuario_id !== auth()->id()) {
            return redirect()->route('publications.my_posts')->with('error', 'Acción no autorizada.');
        }

        // Aplicamos las mismas reglas y mensajes en la edición para mantener consistencia
        $reglas = [
            'titulo'       => ['required', 'string', 'max:100', 'regex:/[\pL]/u'],
            'precio'       => 'required|numeric|min:0',
            'descripcion'  => 'required|string',
            'categoria_id' => 'required|string',
            'estado'       => 'required|string',
            'foto'         => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:10240'
        ];

        $mensajes = [
            'titulo.regex' => 'El título no puede contener solo números, debe incluir letras.',
            'foto.image'   => 'Solo se aceptan imágenes y el archivo que quiere subir no es válido.',
            'foto.mimes'   => 'Solo se aceptan imágenes y el archivo que quiere subir no es válido.',
        ];

        $request->validate($reglas, $mensajes);

        $publicacion->titulo = $request->titulo;
        $publicacion->precio = $request->precio;
        $publicacion->descripcion = $request->descripcion;
        $publicacion->categoria_id = $request->categoria_id;
        $publicacion->estado = $request->estado;

        if ($request->hasFile('foto')) {
            $fotoAnterior = $publicacion->foto_public_id;
            $subida = app(CloudinaryService::class)->subir($request->file('foto'));
            $publicacion->foto = $subida['url'];
            $publicacion->foto_public_id = $subida['public_id'];

            if ($fotoAnterior) {
                app(CloudinaryService::class)->borrar($fotoAnterior);
            }
        }

        $publicacion->save();
        return redirect()->route('publications.my_posts')->with('success', '¡Artículo actualizado con éxito!');
    }

    public function eliminar(Request $request, $id)
    {
        try {
            $publicacion = Publicacion::find($id);

            if (!$publicacion) {
                return response()->json([
                    'estado'  => 'Error',
                    'mensaje' => 'El producto no existe.'
                ], 404);
            }

            if ($request->user()->id != $publicacion->usuario_id) {
                return response()->json([
                    'estado'  => 'Denegado',
                    'mensaje' => 'Solo el propietario puede eliminar su propia publicación.'
                ], 403);
            }

            $fotoPublicId = $publicacion->foto_public_id;
            $publicacion->delete();

            if ($fotoPublicId) {
                app(CloudinaryService::class)->borrar($fotoPublicId);
            }

            return view('publications.my_posts');

        } catch (\Exception $e) {
            return response()->json([
                'estado'  => 'Error',
                'mensaje' => 'Error al intentar eliminar la publicación'
            ], 500);
        }
    }
}