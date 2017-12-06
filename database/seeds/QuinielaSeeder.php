<?php

use Illuminate\Database\Seeder;

class QuinielaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quiniela')->insert([
            'nombre' => "Liga MX",
            'descripcion' => "Quiniela regular de la liga MX",
            'imagen' =>  "http://udgtv.com/wp-content/uploads/2017/06/LigaMX.jpg",
            'id_liga' => 1,
            'permitir_marcador' => true,
            'id_tipo_quiniela' => 1,
            'cantidad_reponches' => 0
        ]);

        DB::table('quiniela')->insert([
            'nombre' => "Liga MX Survivor",
            'descripcion' => "Entra a la quiniela Survivor de la Liga MX.",
            'imagen' =>  "https://i1.wp.com/webadictos.com/media/2017/04/jornada-14-liga-mx-clausura-2017.jpg?resize=800%2C494&ssl=1",
            'id_liga' => 1,
            'permitir_marcador' => true,
            'id_tipo_quiniela' => 11,
            'cantidad_reponches' => 2
        ]);

        DB::table('quiniela')->insert([
            'nombre' => "NFL Regular",
            'descripcion' => "Quiniela regular de la NFL",
            'imagen' =>  "http://www.piodeportes.com/wp-content/uploads/2017/01/madden-25-nfl-week-11-predictions.jpg",
            'id_liga' => 11,
            'permitir_marcador' => true,
            'id_tipo_quiniela' => 1,
            'cantidad_reponches' => 0
        ]);

        DB::table('quiniela')->insert([
            'nombre' => "NFL Survivor",
            'descripcion' => "Quiniela Survivor de la NFL",
            'imagen' =>  "http://periodiconmx.com/wp-content/uploads/2015/03/nfl_week7_09.jpg",
            'id_liga' => 11,
            'permitir_marcador' => true,
            'id_tipo_quiniela' => 11,
            'cantidad_reponches' => 2
        ]);

    }
}
