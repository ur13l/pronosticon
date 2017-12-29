<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_partido')->unsigned();
            $table->foreign('id_partido')->references('id')->on('partido');
            $table->integer('resultado_local');
            $table->integer('resultado_visita');
            $table->integer('id_equipo_ganador')->unsigned()->nullable();
            $table->foreign('id_equipo_ganador')->references('id')->on('equipo');
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
        Schema::dropIfExists('resultados');
    }
}
