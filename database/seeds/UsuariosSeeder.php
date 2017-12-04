<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,34) as $index) {
	        DB::table('usuario')->insert([
	            'nombre' => $faker->name,
                'email' => $faker->email,
                'codigo' =>  str_random(9)
	        ]);
        }
    }
}
