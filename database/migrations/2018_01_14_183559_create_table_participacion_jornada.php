<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableParticipacionJornada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participacion_jornada', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_participacion')->unsigned();
            $table->integer('id_jornada')->unsigned();
            $table->integer('puntuacion')->default(0);
            $table->boolean('registrada');
            $table->foreign('id_participacion')->references('id')->on('participacion');
            $table->foreign('id_jornada')->references('id')->on('jornada');
        });

        Schema::table('pronostico', function(Blueprint $table) {
            $table->integer('id_participacion_jornada')->unsigned();
            $table->foreign('id_participacion_jornada')->references('id')->on('participacion_jornada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
