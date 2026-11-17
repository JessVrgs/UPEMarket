<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->table('users', function (Blueprint $coleccion) {
            $coleccion->unique('email');
        });
    }

    public function down(): void
    {
        // No se revierte: no hace falta en este proyecto.
    }
};