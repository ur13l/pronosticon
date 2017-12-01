<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partido', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_equipo_local')->unsigned();
            $table->foreign('id_equipo_local')->references('id')->on('equipo');
            $table->integer('id_equipo_visita')->unsigned();
            $table->foreign('id_equipo_visita')->references('id')->on('equipo');
            $table->dateTime('fecha_hora');
            $table->integer('id_jornada')->unsigned();
            $table->foreign('id_jornada')->references('id')->on('jornada');
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
        Schema::dropIfExists('partidos');
    }
}
