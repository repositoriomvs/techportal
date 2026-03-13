<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadUsuario extends Model
{
    protected $table = 'actividad_usuarios';

    protected $fillable = [
        'user_id', 'login_at', 'logout_at', 'duracion_minutos', 'ip'
    ];

    protected $casts = [
        'login_at'  => 'datetime',
        'logout_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}