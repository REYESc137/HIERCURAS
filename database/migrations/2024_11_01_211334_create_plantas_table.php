<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_comun', 100);
            $table->string('nombre_cientifico', 100);
            $table->string('otros_nombres', 150)->nullable();
            $table->foreignId('familia_id')->nullable()->constrained('familia')->onDelete('set null');
            $table->foreignId('lugar_origen')->nullable()->constrained('pais')->onDelete('set null');
            $table->foreignId('cientifico_descubridor_id')->nullable()->constrained('descubridores')->onDelete('set null');
            $table->text('descripcion')->nullable();
            $table->string('foto', 255)->nullable();
            $table->foreignId('especies_relacionadas_id')->nullable()->constrained('esp_relac')->onDelete('set null');
            $table->text('uso')->nullable();
            $table->tinyInteger('estatus')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plantas');
    }
};

