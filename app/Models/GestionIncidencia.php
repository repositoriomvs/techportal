<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionIncidencia extends Model
{
    protected $fillable = ['incidencia_id', 'user_id', 'tipo', 'descripcion', 'adjunto'];

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}