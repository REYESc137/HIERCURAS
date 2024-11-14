<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalificacionRecetaTable extends Migration
{
    public function up()
    {
        Schema::create('calificacion_receta', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('receta_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->integer('calificacion')->unsigned(); // Puntuación de la receta, por ejemplo de 1 a 5
            $table->timestamps();

            // Relación con la tabla de recetas
            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('cascade');
            // Relación con la tabla de usuarios
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('calificacion_receta');
    }
}
