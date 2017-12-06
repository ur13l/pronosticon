<?php

use Illuminate\Database\Seeder;

class LigaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('liga')->insert([
            'nombre' => "Liga MX",
            'logo' => "http://a.espncdn.com/combiner/i?img=%2Fi%2Fleaguelogos%2Fsoccer%2F500%2F22.png",
            'imagen' =>  "https://media.metrolatam.com/2017/06/13/201705133726-1200x600.jpg"
        ]);

        DB::table('liga')->insert([
            'nombre' => "NFL",
            'logo' => "http://a.espncdn.com/combiner/i?img=/i/teamlogos/leagues/500/nfl.png",
            'imagen' =>  "http://www.mientrastantoenmexico.mx/wp-content/uploads/2017/09/nfl.gif"
        ]);
    }
}
