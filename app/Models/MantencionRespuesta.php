<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MantencionRespuesta extends Model
{
    protected $fillable = [
        'mantencion_equipo_id',
        'mantencion_item_id',
        'respuesta',
    ];

    public function item()
    {
        return $this->belongsTo(MantencionItem::class, 'mantencion_item_id');
    }

    public function equipo()
    {
        return $this->belongsTo(MantencionEquipo::class, 'mantencion_equipo_id');
    }
}