<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Conversacion extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'conversaciones';
    protected $table = 'conversaciones';

    protected $fillable = [
        'publicacion_id',
        'comprador_id',
        'vendedor_id',
        'mensajes',
    ];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

    public function comprador()
    {
        return $this->belongsTo(User::class, 'comprador_id');
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }
}