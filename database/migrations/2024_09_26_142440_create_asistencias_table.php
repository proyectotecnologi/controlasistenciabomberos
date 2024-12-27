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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->date(column: 'fecha');
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
        Schema::dropIfExists('asistencias');
    }
};
