<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Actualizar datos existentes para evitar errores con el ENUM
        DB::table('dias')
            ->where('name', 'miercoles')
            ->update(['name' => 'miércoles']);

        // 2. Cambiar el ENUM
        DB::statement("ALTER TABLE dias MODIFY COLUMN name ENUM(
            'lunes',
            'martes',
            'miércoles',
            'jueves',
            'viernes',
            'sabado',
            'domingo'
        )");
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        // Revertir cambios si se hace rollback
        DB::table('dias')
            ->where('name', 'miércoles')
            ->update(['name' => 'miercoles']);

        DB::statement("ALTER TABLE dias MODIFY COLUMN name ENUM(
            'lunes',
            'martes',
            'miercoles',
            'jueves',
            'viernes',
            'sabado',
            'domingo'
        )");
    }
};
