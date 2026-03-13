<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'cliente_id', 'nombre', 'descripcion',
        'categoria', 'tipo', 'version',
        'tamanio', 'archivo', 'url',
        'icono', 'user_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}