<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicacionController;

Route::get('/', function () {
    return view('welcome');
});
// ================= formulario de registro de usaurios ===================
Route::get('/registro', [AuthController::class, 'mostrarRegistro']);
Route::post('/registro', [AuthController::class, 'procesarRegistro']);

/*==============CRUD PUBLICACIONES==================*/
Route::get('/publicaciones', [PublicacionController::class, 'consultar']);
Route::post('/publicaciones', [PublicacionController::class, 'crear']);
Route::put('/publicaciones/{id}', [PublicacionController::class, 'actualizar']);
Route::delete('/publicaciones/{id}', [PublicacionController::class, 'eliminar']);