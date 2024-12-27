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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'nombre_division', length: 255);
            $table->string(column: 'seccion', length: 255);
            $table->text(column: 'descripcion')->nullable();
            $table->string(column: 'estado', length: 5);
            $table->string(column: 'fecha_ingreso', length: 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
