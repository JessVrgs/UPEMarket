<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('welcome');
});

// ====================== AUTENTICACIÓN ========================
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'procesarLogin']);

// ================= REGISTRO DE USUARIOS ===================
Route::get('/registro', [AuthController::class, 'mostrarRegistro']);
Route::post('/registro', [AuthController::class, 'procesarRegistro']);

// ================= RUTAS PROTEGIDAS ===================
Route::middleware('auth')->group(function (){

    // Ver detalle de una publicación
    Route::get('/publicaciones/{id}', [PublicacionController::class, 'mostrar'])->name('publications.show');
// Ver detalle de una publicación
    Route::get('/publicaciones/{id}', [PublicacionController::class, 'mostrar'])->name('publications.show');
    // PUBLICACIONES (CRUD)
    Route::get('/publicaciones', [PublicacionController::class, 'consultar']);

    // Ruta para mostrar el formulario de crear publicación
    Route::get('/publicaciones/crear', function () {
        return view('publications.create'); // Ajusta la vista si usas un controlador
    })->name('publications.create');

    Route::post('/publicaciones', [PublicacionController::class, 'crear']);
    Route::put('/publicaciones/{id}', [PublicacionController::class, 'actualizar']);
    Route::delete('/publicaciones/{id}', [PublicacionController::class, 'eliminar']);

    // PERFIL DE USUARIO
    Route::get('/perfil', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::get('/publications', function () {
        return view('publications.my_posts');
    })->name('publications.my_posts');

    // CATEGORÍAS
    Route::get('/categorias', [CategoriaController::class, 'consultar']);

    // CERRAR SESIÓN
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
