<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Mensaje extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'mensajes';

    protected $fillable = [
        'emisor_id',
        'receptor_id',
        'publicacion_id',
        'mensaje',
    ];

    public function emisor()
    {
        return $this->belongsTo(User::class, 'emisor_id');
    }

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }
}
