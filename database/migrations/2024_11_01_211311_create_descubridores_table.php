<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('descubridores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->foreignId('pais_id')->nullable()->constrained('pais')->onDelete('set null');
            $table->string('lugar_nacimiento', 255)->nullable();
            $table->text('expediciones')->nullable();
            $table->text('biografia')->nullable();
            $table->string('foto', 255)->nullable();
            $table->date('fecha_descubrimiento')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('descubridores');
    }
};

