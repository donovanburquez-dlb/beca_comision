<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * MODELO: PersonalCatalogo
 * 
 * PROPÓSITO:
 * Este modelo representa la tabla 'personal_catalogo'.
 * Es el catálogo general de personal de la institución.
 * 
 * CUÁNDO SE USA:
 * Cuando el operador ingresa un RFC en el formulario,
 * buscamos en esta tabla para autocompletar los datos.
 */
class PersonalCatalogo extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos
     */
    protected $table = 'personal_catalogo';

    /**
     * Campos que se pueden llenar masivamente
     */
    protected $fillable = [
            'rfc', 'curp', 'apellido_pat', 'apellido_mat', 'nombres', 'sexo', 'edad',
            'tel_particular', 'correo', 'domicilio',
            'cct', 'centro_trabajo', 'nivel', 'localidad', 'municipio',
            'turno', 'asignatura', 'horas', 'clave_plaza'
    ];

    /**
     * Conversión automática de tipos de datos
     */
    protected $casts = [
        'edad' => 'integer',
        'horas' => 'integer',
    ];

    /**
     * Accessor: Nombre Completo
     */
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombres} {$this->apellido_pat} {$this->apellido_mat}");
    }

    /**
     * Scope: Por RFC
     */
    public function scopePorRfc($query, $rfc)
    {
        return $query->where('rfc', strtoupper(trim($rfc)));
    }

    /**
     * Scope: Buscar en múltiples campos
     */
    public function scopeBuscar($query, $texto)
    {
        if (empty($texto)) {
            return $query;
        }

        $texto = strtoupper(trim($texto));

        return $query->where(function($q) use ($texto) {
            $q->where('rfc', 'LIKE', "%{$texto}%")
            ->orWhere('curp', 'LIKE', "%{$texto}%")
            ->orWhere('nombres', 'LIKE', "%{$texto}%")
            ->orWhere('apellido_pat', 'LIKE', "%{$texto}%")
            ->orWhere('apellido_mat', 'LIKE', "%{$texto}%");
        });
    }

    /**
     * Obtiene los datos para autocompletar el formulario
     */
    public function datosParaAutocompletar()
    {
        return [
            'rfc' => $this->rfc,
            'curp' => $this->curp,
            'apellido_pat' => $this->apellido_pat,
            'apellido_mat' => $this->apellido_mat,
            'nombres' => $this->nombres,
            'sexo' => $this->sexo,
            'edad' => $this->edad,
            'correo' => $this->correo,
            'tel_particular' => $this->tel_particular,
            'domicilio' => $this->domicilio,
            'cct' => $this->cct,
            'centro_trabajo' => $this->centro_trabajo,
            'nivel' => $this->nivel,
            'localidad' => $this->localidad,
            'municipio' => $this->municipio,
            'turno' => $this->turno,
            'asignatura' => $this->asignatura,
            'horas' => $this->horas,
            'clave_plaza' => $this->clave_plaza,
        ];
    }
}