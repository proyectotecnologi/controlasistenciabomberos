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
        Schema::create('asistenciasalidas', function (Blueprint $table) {
            $table->id();
            $table->dateTime(column: 'fecha_salida');
            $table->string(column: 'motivo_salida', length: 255);
            $table->bigInteger(column: 'miembro_id')->unsigned();
            $table->timestamps();
            $table->foreign(columns: 'miembro_id')->references(columns:'id')->on(table:'miembros')->onDelete(action: 'cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistenciasalidas');
    }
};
