<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->table('usuarios', fn (Blueprint $c) => $c->unique('email'));
        Schema::connection('mongodb')->table('categorias', fn (Blueprint $c) => $c->unique('slug'));
        Schema::connection('mongodb')->table('favoritos', fn (Blueprint $c) => $c->unique(['usuario_id', 'publicacion_id']));
        Schema::connection('mongodb')->table('publicaciones', fn (Blueprint $c) => $c->index(['categoria_id', 'estado', 'created_at']));
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('favoritos');
    }
};