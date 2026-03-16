<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MantencionEquipo extends Model
{
    protected $fillable = [
        'mantencion_orden_id', 'tipo',
        'marca', 'modelo', 'serie',
        'observaciones', 'estado_final',
        'foto_equipo', 'foto_serie',
    ];

    public function orden()
    {
        return $this->belongsTo(MantencionOrden::class, 'mantencion_orden_id');
    }

    public function respuestas()
    {
        return $this->hasMany(MantencionRespuesta::class);
    }

    public function getTipoLabelAttribute(): string
    {
        return [
            'impresora_sin_adf'   => 'IMPRESORA SIN ADF',
            'impresora_con_adf'   => 'IMPRESORA CON ADF',
            'impresora_termica'   => 'IMPRESORA TÉRMICA',
            'computador_aio'      => 'COMPUTADOR ALL IN ONE',
            'computador_desktop'  => 'COMPUTADOR DESKTOP',
            'computador_notebook' => 'COMPUTADOR NOTEBOOK',
        ][$this->tipo] ?? strtoupper($this->tipo);
    }
}