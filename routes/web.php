<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\PublicacionController;
    use App\Http\Controllers\CategoriaController;
    use App\Http\Controllers\ConversacionController;

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
    Route::middleware('auth')->group(function () {

        // PUBLICACIONES (CRUD)
        Route::get('/publicaciones', [PublicacionController::class, 'consultar'])->name('publications.index');

        // Importante: '/publicaciones/crear' debe ir ANTES de '/publicaciones/{id}'
        Route::get('/publicaciones/crear', function () {
            return view('publications.create');
        })->name('publications.create');
        Route::get('/publicaciones/{id}', [PublicacionController::class, 'mostrar'])->name('publications.show');
        //publicaciones editar
        Route::get('/publicaciones/{id}/editar', [PublicacionController::class, 'editar'])->name('publications.edit');
        Route::put('/publicaciones/{id}', [PublicacionController::class, 'actualizar'])->name('publications.update');
        Route::get('/publicaciones/{id}/eliminar', [PublicacionController::class, 'eliminar'])->name('publications.delete');

        Route::post('/publicaciones', [PublicacionController::class, 'crear']);
        Route::put('/publicaciones/{id}', [PublicacionController::class, 'actualizar']);
        Route::delete('/publicaciones/{id}', [PublicacionController::class, 'eliminar']);

        // CONVERSACIONES / MENSAJES (Usando ConversacionController con las vistas de tu compañero)
        Route::get('/mensajes', [ConversacionController::class, 'consultarConversacion'])->name('mensajes.index');
        Route::get('/mensajes/{id}', [ConversacionController::class, 'verChat'])->name('mensajes.chat');
        Route::post('/mensajes', [ConversacionController::class, 'enviarMensajes'])->name('mensajes.enviar');

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