<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialVisita extends Model
{
    protected $fillable = [
        'user_id', 'tipo', 'recurso_id',
        'recurso_nombre', 'recurso_url',
        'ultima_pagina', 'visitado_at'
    ];

    protected $casts = [
        'visitado_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}