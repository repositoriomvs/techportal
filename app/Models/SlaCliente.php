<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlaCliente extends Model
{
    protected $table = 'sla_clientes';

    protected $fillable = ['cliente_id', 'prioridad', 'horas_respuesta', 'horas_resolucion'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}