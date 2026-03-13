<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $fillable = [
        'user_id', 'titulo', 'contenido',
        'tipo', 'url', 'url_texto',
        'activo', 'publicado_at'
    ];

    protected $casts = [
        'activo'       => 'boolean',
        'publicado_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}