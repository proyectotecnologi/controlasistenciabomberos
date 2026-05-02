<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';

    protected $fillable = [
        'desde',
        'hasta',
        'motivo',
        'descripcion',
        'miembro_id'
    ];

    // Relación: Un permiso pertenece a un miembro
    public function miembro(): BelongsTo
    {
        return $this->belongsTo(Miembro::class);
    }
}
