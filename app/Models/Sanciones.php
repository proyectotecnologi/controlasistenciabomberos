<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'mes', 'enviado', 'tipo', 'observaciones', 'miembro_id'
    ];

    protected $casts = [
        'enviado' => 'boolean',
    ];

    // Relación con miembro
    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
    }

    // Accesor para el tipo de sanción
    public function getTipoTextoAttribute()
    {
        $tipos = [
            '1' => 'Memorándum Leve',
            '2' => 'Memorándum Moderado', 
            '3' => 'Memorándum Grave'
        ];
        
        return $tipos[$this->tipo] ?? 'Desconocido';
    }

    // Accesor para el mes formateado
    public function getMesFormateadoAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m', $this->mes)
            ->translatedFormat('F Y');
    }
}