<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Asignacion extends Model
{

    protected $table = 'asignacion_horario';
    protected $fillable = ['hora_entrada', 'hora_salida', 'estado', 'miembro_id'];


    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
    }


    // Relación con los días
    public function dias()
    {
        return $this->hasMany(Dia::class, 'asignacion_horario_id');
    }

    
}
