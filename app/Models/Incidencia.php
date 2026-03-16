<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Incidencia extends Model
{
    protected $fillable = [
        'numero_ticket','cliente_id','local_id','agente_id','tecnico_id',
        'canal_ingreso','nombre_contacto','telefono_contacto',
        'tipo_ticket','categoria_equipo','tipo_equipo',
        'marca_equipo','modelo_equipo','serie_equipo','serie_temporal','ubicacion_equipo',
        'asunto','descripcion_falla','adjunto','prioridad',
        'estado_mesa','estado_tecnico',
        'categoria_cierre','subcategoria_cierre','comentario_cierre','serie_equipo_real',
        'fecha_asignacion','fecha_limite_respuesta','fecha_limite_resolucion',
        'fecha_primera_atencion','closed_at',
    ];

    protected $casts = [
        'fecha_asignacion'         => 'datetime',
        'fecha_limite_respuesta'   => 'datetime',
        'fecha_limite_resolucion'  => 'datetime',
        'fecha_primera_atencion'   => 'datetime',
        'closed_at'                => 'datetime',
        'serie_temporal'           => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($incidencia) {
            $ultimo = static::whereYear('created_at', now()->year)->max('id') ?? 0;
            $incidencia->numero_ticket = 'INC-' . now()->year . '-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function cliente()    { return $this->belongsTo(Cliente::class); }
    public function local()      { return $this->belongsTo(Local::class); }
    public function agente()     { return $this->belongsTo(User::class, 'agente_id'); }
    public function tecnico()    { return $this->belongsTo(User::class, 'tecnico_id'); }
    public function gestiones()  { return $this->hasMany(GestionIncidencia::class); }

    public function slaRespuestaCumplido(): bool
    {
        if (!$this->fecha_primera_atencion || !$this->fecha_limite_respuesta) return false;
        return $this->fecha_primera_atencion->lte($this->fecha_limite_respuesta);
    }

    public function slaResolucionCumplido(): bool
    {
        if (!$this->closed_at || !$this->fecha_limite_resolucion) return false;
        return $this->closed_at->lte($this->fecha_limite_resolucion);
    }
}