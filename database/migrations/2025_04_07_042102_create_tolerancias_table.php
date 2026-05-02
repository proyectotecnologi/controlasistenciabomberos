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
        Schema::create('tolerancias', function (Blueprint $table) {
            $table->id();

            $table->time('atraso_por_minuto');
            // Minutos de atraso permitidos antes de marcar faltas o sancines
            $table->time('salida_anticipada');
            // tiempo minimo antes de la hora de salida para considerar que salio antes
            $table->time('tolerancia_maxima_entrada');
            // Límite máximo de tolerancia al entrar: pasado esto, ya es atraso real
            $table->time('maximo_salida');
            // Hora maxima de salida permitida; despues se considera tiempo extra o infracción
            $table->time('antelacion_marcado');
            // Cuanto antes se puede marcar la entrada son que se rechace
            $table->time('antelacion_salida');
            // Cuanto antes se puede marcar la salida son que se tome como salida anticipada
            $table->timestamps(); // ← Esto faltaba
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tolerancias');
    }
};
