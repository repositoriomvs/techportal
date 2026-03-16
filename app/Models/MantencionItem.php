<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MantencionItem extends Model
{
    protected $fillable = [
        'tipo_equipo', 'seccion', 'descripcion',
        'tipo_respuesta', 'es_critico', 'orden',
    ];

    protected $casts = [
        'es_critico' => 'boolean',
    ];
}