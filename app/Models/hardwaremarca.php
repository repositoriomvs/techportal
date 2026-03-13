<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HardwareMarca extends Model
{
    protected $fillable = ['hardware_tipo_id', 'nombre', 'icono'];

    public function tipo()
    {
        return $this->belongsTo(\App\Models\HardwareTipo::class, 'hardware_tipo_id', 'id');
    }

    public function modelos()
    {
        return $this->hasMany(\App\Models\HardwareModelo::class);
    }
}
