<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HardwareTipo extends Model
{
    protected $fillable = ['nombre', 'icono', 'descripcion'];

    public function marcas()
    {
        return $this->hasMany(HardwareMarca::class);
    }

    public function recursos()
    {
        return $this->hasMany(HardwareRecurso::class);
    }
}
