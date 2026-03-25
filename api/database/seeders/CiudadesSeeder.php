<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CiudadesSeeder extends Seeder
{
    public function run(): void
    {
        $ciudades = [

            // ── SINALOA (estado_id = 1) ──────────────────────
            ['estado_id' => 1, 'nombre' => 'Culiacán',           'codigo_postal' => '80000', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Mazatlán',           'codigo_postal' => '82000', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Los Mochis',         'codigo_postal' => '81200', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Guasave',            'codigo_postal' => '81000', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Guamúchil',          'codigo_postal' => '81400', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Navolato',           'codigo_postal' => '80370', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'El Fuerte',          'codigo_postal' => '81820', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Choix',              'codigo_postal' => '81700', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Mocorito',           'codigo_postal' => '80600', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Angostura',          'codigo_postal' => '81600', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Badiraguato',        'codigo_postal' => '80700', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Cosalá',             'codigo_postal' => '80900', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'San Ignacio',        'codigo_postal' => '82600', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Concordia',          'codigo_postal' => '82500', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Rosario',            'codigo_postal' => '82800', 'activo' => true],
            ['estado_id' => 1, 'nombre' => 'Escuinapa',          'codigo_postal' => '82400', 'activo' => true],

            // ── CHIHUAHUA (estado_id = 2) ────────────────────
            ['estado_id' => 2, 'nombre' => 'Chihuahua',          'codigo_postal' => '31000', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Ciudad Juárez',      'codigo_postal' => '32000', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Delicias',           'codigo_postal' => '33000', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Cuauhtémoc',         'codigo_postal' => '31500', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Parral',             'codigo_postal' => '33800', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Ojinaga',            'codigo_postal' => '32880', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Camargo',            'codigo_postal' => '33700', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Jiménez',            'codigo_postal' => '33980', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Nuevo Casas Grandes','codigo_postal' => '31700', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Casas Grandes',      'codigo_postal' => '31800', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Creel',              'codigo_postal' => '33200', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Madera',             'codigo_postal' => '31900', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Guerrero',           'codigo_postal' => '31600', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Bocoyna',            'codigo_postal' => '33180', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Guachochi',          'codigo_postal' => '33100', 'activo' => true],
            ['estado_id' => 2, 'nombre' => 'Balleza',            'codigo_postal' => '33900', 'activo' => true],
        ];

        DB::table('ciudades')->insert($ciudades);
    }
}
