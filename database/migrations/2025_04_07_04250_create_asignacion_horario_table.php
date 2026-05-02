<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asignacion_horario', function (Blueprint $table) {
            $table->id();
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->boolean('estado')->default(true);

            // Si quieres mantener asignaciones aunque el miembro se borre:
            $table->foreignId('miembro_id')
                ->nullable()
                ->constrained('miembros')
                ->nullOnDelete(); // ← Deja el campo en NULL si borran al miembro

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_horario');
    }
};
