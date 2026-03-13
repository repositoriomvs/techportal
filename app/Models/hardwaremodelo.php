<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HardwareModelo extends Model
{
    protected $fillable = [
        'hardware_marca_id', 'nombre',
        'numero_parte', 'descripcion'
    ];

  public function marca()
{
    return $this->belongsTo(HardwareMarca::class, 'hardware_marca_id', 'id');
}

    public function recursos()
    {
        return $this->hasMany(HardwareRecurso::class);
    }
}