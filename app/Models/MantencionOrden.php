<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MantencionOrden extends Model
{
    protected $table = 'mantencion_ordenes';

    protected $fillable = [
        'cliente_id', 'user_id', 'numero_orden',
        'fecha', 'hora_inicio', 'hora_termino',
        'codigo_local', 'direccion', 'ciudad',
        'firma_nombre', 'firma_cargo', 'firma_imagen',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipos()
    {
        return $this->hasMany(MantencionEquipo::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($orden) {
            $ultimo = self::max('id') ?? 0;
            $orden->numero_orden = 'ORD-' . date('Y') . '-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
        });
    }
}