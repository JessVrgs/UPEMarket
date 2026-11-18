<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Categoria extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'categorias';
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'slug',
    ];

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'categoria_id');
    }
}