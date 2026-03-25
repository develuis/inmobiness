<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['id' => 1, 'nombre' => 'Sinaloa',   'codigo' => 'SIN', 'activo' => true],
            ['id' => 2, 'nombre' => 'Chihuahua',  'codigo' => 'CHH', 'activo' => true],
        ];

        DB::table('estados')->insert($estados);
    }
}
