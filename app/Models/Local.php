<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locales';
    
    protected $fillable = [
        'cliente_id',
        'codigo', 
        'direccion',
        'ciudad',
        'region'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}