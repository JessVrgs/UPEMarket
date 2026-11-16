<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Reporte extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reportes';

    protected $fillable = [
        'publicacion_id',
        'reportado_por',
        'motivo',
        'estado',
    ];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

    public function reportador()
    {
        return $this->belongsTo(User::class, 'reportado_por');
    }
}