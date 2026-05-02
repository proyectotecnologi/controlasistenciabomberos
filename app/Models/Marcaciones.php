<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marcaciones extends Model
{
    protected $table = 'marcaciones';
   
    protected $fillable = ['fecha_marcacion', 'carnet']; 
    
    public function miembro()
    {
        return $this->belongsTo(Miembro::class, 'carnet', 'ci');
    }
}
