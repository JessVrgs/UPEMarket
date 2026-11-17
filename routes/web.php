<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MensajeController;

Route::get('/', function () {
    return view('welcome');
});

// ====================== LOGIN ========================
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'procesarLogin']);

// ================= REGISTRO DE USUARIOS ===================
Route::get('/registro', [AuthController::class, 'mostrarRegistro']);
Route::post('/registro', [AuthController::class, 'procesarRegistro']);

// ================= RUTAS PROTEGIDAS POR AUTENTICACIÓN ===================
Route::middleware('auth')->group(function (){

    // 1. RUTAS ESTÁTICAS DE PUBLICACIONES Y MENSAJES
    Route::get('/publicaciones', [PublicacionController::class, 'consultar']);

    Route::get('/publicaciones/crear', function () {
        return view('publications.create');
    })->name('publications.create');

    Route::get('/mis-publicaciones', function () {
        return view('publications.my_posts');
    })->name('publications.my_posts');

    // Mensajes y Chat (Bandeja y Envío)
    Route::get('/mensajes', [MensajeController::class, 'bandeja'])->name('mensajes.index');

    // 2. RUTAS DINÁMICAS CON PARÁMETROS {id} (Deben ir después de las estáticas)
    Route::get('/publicaciones/{id}/editar', [PublicacionController::class, 'editarFormulario'])->name('publications.edit');
    Route::get('/publicaciones/{id}', [PublicacionController::class, 'mostrar'])->name('publications.show');

    // 3. ACCIONES DE PROCESAMIENTO (POST, PUT, DELETE)
    Route::post('/publicaciones', [PublicacionController::class, 'crear']);
    Route::put('/publicaciones/{id}', [PublicacionController::class, 'actualizar']);
    Route::delete('/publicaciones/{id}', [PublicacionController::class, 'eliminar']);

    Route::post('/mensajes/enviar', [MensajeController::class, 'enviar'])->name('mensajes.enviar');

    // PERFIL Y ACTIVIDAD DEL ESTUDIANTE
    Route::get('/perfil', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::get('/users', function () {
        return view('users.management');
    })->name('users.management');

    Route::get('/mensajes/chat/{id}', [MensajeController::class, 'chatPrivado'])->name('mensajes.chat');

    Route::get('/message', function () {
        return view('message.index');
    })->name('message.index');

    Route::get('/message', function () {
        return view('message.show');
    })->name('message.show');

    // CATEGORÍAS
    Route::get('/categorias', [CategoriaController::class, 'consultar'])->name('categorias.index');

    // CERRAR SESIÓN
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
