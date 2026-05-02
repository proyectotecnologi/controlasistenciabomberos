<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sanciones', function (Blueprint $table) {
            $table->id();
            $table->string('mes'); // Formato: Y-m (2024-01)
            $table->boolean('enviado')->default(false);
            $table->enum('tipo', ['1', '2', '3']); // 1: Leve, 2: Moderada, 3: Grave
            $table->text('observaciones')->nullable();
            
            $table->foreignId('miembro_id')
                ->constrained('miembros')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanciones');
    }
};