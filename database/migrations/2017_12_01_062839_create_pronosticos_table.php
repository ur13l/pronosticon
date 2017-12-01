<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePronosticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pronostico', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_participacion')->unsigned();
            $table->foreign('id_participacion')->references('id')->on('participacion');
            $table->integer('id_partido')->unsigned();
            $table->foreign('id_partido')->references('id')->on('partido');
            $table->integer('id_equipo_ganador')->unsigned();
            $table->foreign('id_equipo_ganador')->references('id')->on('equipo');
            $table->integer('puntos');
            $table->integer('resultado_local');
            $table->integer('resultado_visita');
            $table->boolean('victoria');
            $table->dateTime('fecha');
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
        Schema::dropIfExists('pronosticos');
    }
}
