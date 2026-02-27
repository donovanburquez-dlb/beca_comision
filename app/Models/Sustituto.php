<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sustituto extends Model
{
    protected $table = 'sustitutos';

    protected $fillable = [
        'maestro_id', 'rfc', 'nombre_completo', 
        'fecha_inicio', 'fecha_termino', 
        'telefono', 'estatus', 'observaciones'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date',
    ];

    /**
     * RELACIÓN: Este sustituto pertenece a la beca de un maestro
     */
    public function maestro()
    {
        return $this->belongsTo(Maestro::class);
    }
}