<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBolsaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa', function (Blueprint $table) {
            $table->increments('id');
            $table->float('cantidad');
            $table->integer('id_quiniela')->unsigned();
            $table->foreign('id_quiniela')->references('id')->on('quiniela');
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
        Schema::dropIfExists('bolsa');
    }
}
