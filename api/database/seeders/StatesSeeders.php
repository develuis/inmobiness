<?php

namespace Database\Seeders;

// database/seeders/EstadosSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            ['id' => 1, 'nombre' => 'Sinaloa',   'codigo' => 'SI'],
            ['id' => 2, 'nombre' => 'Chihuahua',  'codigo' => 'CH'],
        ];

        DB::table('states')->insert($estados);
    }
}
