<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Asistenciasalida
 *
 * @property $id
 * @property $fecha_salida
 * @property $motivo_salida
 * @property $miembro_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Miembro $miembro
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Asistenciasalida extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_salida', 'motivo_salida', 'miembro_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function miembro()
    {
        return $this->belongsTo(\App\Models\Miembro::class, 'miembro_id', 'id');
    }
    
}
