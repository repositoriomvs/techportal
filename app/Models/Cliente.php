<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre', 'codigo', 'contacto',
        'email', 'telefono', 'estado',
        'color', 'notas',
        'tiene_sla',
        'sla_horas_respuesta',
        'sla_horas_resolucion',
        'sla_horas_cambio_equipo',
    ];

    protected $casts = [
        'tiene_sla' => 'boolean',
    ];

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function getInicialesAttribute()
    {
        $words = explode(' ', $this->nombre);
        return strtoupper(
            substr($words[0], 0, 1) .
            (isset($words[1]) ? substr($words[1], 0, 1) : substr($words[0], 1, 1))
        );
    }
}
