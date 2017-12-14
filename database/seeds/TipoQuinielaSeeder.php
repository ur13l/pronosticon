<?php

use Illuminate\Database\Seeder;

class TipoQuinielaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_quiniela')->insert([
            'nombre' => "Regular",
            'survivor' => false,
        ]);

        DB::table('tipo_quiniela')->insert([
            'nombre' => "Survivor",
            'survivor' => true,
        ]);
    }
}
