<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReponcheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reponches', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_jornada')->unsigned();
            $table->foreign('id_jornada')->references('id')->on('jornada');
            $table->integer('id_participacion')->unsigned();
            $table->foreign('id_participacion')->references('id')->on('participacion');
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
        //
    }
}
