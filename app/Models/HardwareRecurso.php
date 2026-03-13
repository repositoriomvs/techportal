<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HardwareRecurso extends Model
{
    protected $fillable = [
        'hardware_modelo_id', 'hardware_tipo_id',
        'nombre', 'descripcion', 'categoria',
        'tipo', 'version', 'tamanio',
        'archivo', 'url', 'user_id'
    ];

    public function modelo()
    {
        return $this->belongsTo(HardwareModelo::class, 'hardware_modelo_id');
    }

    public function hardwareTipo()
    {
        return $this->belongsTo(HardwareTipo::class, 'hardware_tipo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
    'hardware_modelo_id', 'hardware_tipo_id',
    'nombre', 'descripcion', 'categoria',
    'tipo', 'version', 'tamanio',
    'archivo', 'url', 'user_id', 'icono'
];
}
