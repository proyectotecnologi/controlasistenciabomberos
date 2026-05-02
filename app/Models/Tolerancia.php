<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tolerancia extends Model
{
    use HasFactory;

    protected $table = 'tolerancias';

    protected $fillable = [
        'atraso_por_minuto',
        'salida_anticipada',
        'tolerancia_maxima_entrada',
        'maximo_salida',
        'antelacion_marcado',
        'antelacion_salida'
    ];
}
