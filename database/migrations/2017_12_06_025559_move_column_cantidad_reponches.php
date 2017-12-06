<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveColumnCantidadReponches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_quiniela',function (Blueprint $table) {
            $table->dropColumn('cantidad_reponches');
        });

        Schema::table('quiniela',function (Blueprint $table) {
            $table->integer('cantidad_reponches');
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
