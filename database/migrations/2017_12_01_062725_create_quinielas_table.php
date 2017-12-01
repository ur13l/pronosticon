<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuinielasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiniela', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 200);
            $table->string('descripcion', 1000);
            $table->string('imagen', 1000);
            $table->boolean('permitir_marcador');
            $table->integer('id_liga')->unsigned();
            $table->foreign('id_liga')->references('id')->on('liga');
            $table->integer('id_tipo_quiniela')->unsigned();
            $table->foreign('id_tipo_quiniela')->references('id')->on('tipo_quiniela');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quinielas');
    }
}
