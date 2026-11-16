<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Publicacion extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'publicaciones';

    protected $fillable = [
        'usuario_id',
        'categoria_id',
        'titulo',
        'descripcion',
        'precio',
        'foto',      // <-- Actualizado a singular para que coincida con el controlador
        'fotos',     // <-- Lo dejamos por compatibilidad por si usas ambos
        'estado',
        'oculta',
    ];

    protected $casts = [
        'precio' => 'float',
        'oculta' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'publicacion_id');
    }

    public function conversaciones()
    {
        return $this->hasMany(Conversacion::class, 'publicacion_id');
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'publicacion_id');
    }
}
