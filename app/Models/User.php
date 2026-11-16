<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'mongodb';
    protected $collection = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'carrera',
        'telefono',
        'rol',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'usuario_id');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'usuario_id');
    }

    public function conversacionesComoComprador()
    {
        return $this->hasMany(Conversacion::class, 'comprador_id');
    }

    public function conversacionesComoVendedor()
    {
        return $this->hasMany(Conversacion::class, 'vendedor_id');
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'reportado_por');
    }
}