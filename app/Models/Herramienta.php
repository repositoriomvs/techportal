<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    protected $fillable = [
        'user_id', 'nombre', 'categoria', 'tipo',
        'archivo', 'url', 'descripcion',
        'tamanio', 'icono', 'version',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}