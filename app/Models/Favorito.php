<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Favorito extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'favoritos';

    protected $fillable = [
        'usuario_id',
        'publicacion_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }
}