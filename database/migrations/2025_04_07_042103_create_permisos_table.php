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
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->date('desde');
            $table->date('hasta');
            $table->enum('motivo', [
                'permiso',
                'comision',
                'salud',
                'enfermedad',
                'familiar',
                'duelo',
                'estudio',
                'capacitacion',
                'vacacion',
                'tramite',
                'judicial',
                'otros',
            ]);

            $table->text('descripcion')->nullable();

            $table->foreignId('miembro_id')
                ->constrained('miembros')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
