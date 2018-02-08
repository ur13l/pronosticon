<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableLiga1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('deporte', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
        });


        Schema::table('liga', function(Blueprint $table) {
            $table->integer('id_deporte')->unsigned()->nullable();
            $table->foreign('id_deporte')->references('id')->on('deporte');

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
