<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PronosticoNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pronostico', function (Blueprint $table) {
            $table->integer('id_equipo_ganador')->unsigned()->nullable()->change();
            $table->integer('resultado_local')->nullable()->change();
            $table->integer('resultado_visita')->nullable()->change();
            $table->boolean('victoria')->nullable()->change();
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
