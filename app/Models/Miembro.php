<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Miembro extends Model
{
    use HasFactory;

    // protected $table = 'miembros';

    // Relación: Un miembro tiene una asignación
    public function asignacion(): HasOne
    {
        return $this->hasOne(Asignacion::class, 'miembro_id');
    }

    // Relación: Un miembro puede tener muchos permisos
    public function permisos(): HasMany
    {
        return $this->hasMany(Permiso::class);
    }

    // Relación con días a través de asignación
    public function diasAsignados()
    {
        return $this->hasManyThrough(Dia::class, Asignacion::class, 'miembro_id', 'asignacion_horario_id');
    }

    // Nueva relación con sanciones
    public function sanciones()
    {
        return $this->hasMany(Sancion::class);
    }

    // Método para verificar si tiene sanción en el mes actual
    public function tieneSancionEsteMes()
    {
        $mesActual = \Carbon\Carbon::now()->format('Y-m');
        return $this->sanciones()
            ->where('mes', $mesActual)
            ->where('enviado', true)
            ->exists();
    }

    // Método para obtener la sanción del mes actual
    public function sancionActual()
    {
        $mesActual = \Carbon\Carbon::now()->format('Y-m');
        return $this->sanciones()
            ->where('mes', $mesActual)
            ->first();
    }

    // Método para verificar si tiene sanción en un mes específico
public function tieneSancionEnMes($mes, $anio)
{
    $mesFormateado = \Carbon\Carbon::create($anio, $mes, 1)->format('Y-m');
    return $this->sanciones()
        ->where('mes', $mesFormateado)
        ->where('enviado', true)
        ->exists();
}

// Método para obtener la sanción de un mes específico
public function sancionEnMes($mes, $anio)
{
    $mesFormateado = \Carbon\Carbon::create($anio, $mes, 1)->format('Y-m');
    return $this->sanciones()
        ->where('mes', $mesFormateado)
        ->first();
}

}
