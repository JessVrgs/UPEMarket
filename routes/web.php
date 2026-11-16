<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ConversacionController;
use App\Http\Controllers\FavoritoController;

Route::get('/', function () {
    return view('welcome');
});

// ====================== LOGIN ========================
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'procesarLogin']);

// ================= REGISTRO DE USUARIOS ===================
Route::get('/registro', [AuthController::class, 'mostrarRegistro']);
Route::post('/registro', [AuthController::class, 'procesarRegistro']);

Route::middleware('auth')->group(function (){
    /*============== CRUD PUBLICACIONES ==================*/
    Route::get('/publicaciones', [PublicacionController::class, 'consultar']);
    Route::post('/publicaciones', [PublicacionController::class, 'crear']);
    Route::put('/publicaciones/{id}', [PublicacionController::class, 'actualizar']);
    Route::delete('/publicaciones/{id}', [PublicacionController::class, 'eliminar']);

    // CATEGORÍAS
    Route::get('/categorias', [CategoriaController::class, 'consultar']);

    //Mensajes
    Route::post('/mensajes', [ConversacionController::class, 'enviarMensaje']); 
    Route::get('/mis-mensajes', [ConversacionController::class, 'consultarConversaciones']);

    //Favoritos
    Route::post('/favoritos', [FavoritoController::class, 'agregarFavorito']);
    Route::get('/mis-favoritos', [FavoritoController::class, 'consultarFavoritos']);
    Route::delete('/favoritos/{publicacion_id}', [FavoritoController::class, 'eliminarFavorito']);
    
    // ********* cerrar sesión ************
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
