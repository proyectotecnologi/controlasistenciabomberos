<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dia extends Model
{
    use HasFactory;

    protected $table = 'dias';

    protected $fillable = [
        'name',
        'asignacion_horario_id',
    ];

    public function asignacion_horario(): BelongsTo
    {
        return $this->belongsTo(Asignacion::class, 'asignacion_horario_id');
    }

     public function asignacion()
    {
        return $this->belongsTo(Asignacion::class, 'asignacion_horario_id');
    }
}
