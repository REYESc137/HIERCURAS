<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('ingredientes');
            $table->text('preparacion');
            $table->integer('tiempo_preparacion')->nullable(); // En minutos
            $table->string('foto')->nullable();
            $table->foreignId('dificultad_id')->constrained('dificultades')->onDelete('set null'); // Relación con dificultades
            $table->foreignId('planta_id')->constrained('plantas')->onDelete('set null'); // Relación con plantas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};

