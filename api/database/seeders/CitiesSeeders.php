<?php

namespace Database\Seeders;




use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        $municipios = [

            // ── SINALOA (estado_id = 1) ──────────────────────────
            ['estado_id' => 1, 'nombre' => 'Ahome'],
            ['estado_id' => 1, 'nombre' => 'Angostura'],
            ['estado_id' => 1, 'nombre' => 'Badiraguato'],
            ['estado_id' => 1, 'nombre' => 'Concordia'],
            ['estado_id' => 1, 'nombre' => 'Cosalá'],
            ['estado_id' => 1, 'nombre' => 'Culiacán'],
            ['estado_id' => 1, 'nombre' => 'Choix'],
            ['estado_id' => 1, 'nombre' => 'Elota'],
            ['estado_id' => 1, 'nombre' => 'Escuinapa'],
            ['estado_id' => 1, 'nombre' => 'El Fuerte'],
            ['estado_id' => 1, 'nombre' => 'Guasave'],
            ['estado_id' => 1, 'nombre' => 'Mazatlán'],
            ['estado_id' => 1, 'nombre' => 'Mocorito'],
            ['estado_id' => 1, 'nombre' => 'Rosario'],
            ['estado_id' => 1, 'nombre' => 'Salvador Alvarado'],
            ['estado_id' => 1, 'nombre' => 'San Ignacio'],
            ['estado_id' => 1, 'nombre' => 'Sinaloa'],
            ['estado_id' => 1, 'nombre' => 'Navolato'],

            // ── CHIHUAHUA (estado_id = 2) ─────────────────────────
            ['estado_id' => 2, 'nombre' => 'Ahumada'],
            ['estado_id' => 2, 'nombre' => 'Aldama'],
            ['estado_id' => 2, 'nombre' => 'Allende'],
            ['estado_id' => 2, 'nombre' => 'Aquiles Serdán'],
            ['estado_id' => 2, 'nombre' => 'Ascensión'],
            ['estado_id' => 2, 'nombre' => 'Bachíniva'],
            ['estado_id' => 2, 'nombre' => 'Balleza'],
            ['estado_id' => 2, 'nombre' => 'Batopilas'],
            ['estado_id' => 2, 'nombre' => 'Bocoyna'],
            ['estado_id' => 2, 'nombre' => 'Buenaventura'],
            ['estado_id' => 2, 'nombre' => 'Camargo'],
            ['estado_id' => 2, 'nombre' => 'Carichí'],
            ['estado_id' => 2, 'nombre' => 'Casas Grandes'],
            ['estado_id' => 2, 'nombre' => 'Chihuahua'],
            ['estado_id' => 2, 'nombre' => 'Chínipas'],
            ['estado_id' => 2, 'nombre' => 'Coronado'],
            ['estado_id' => 2, 'nombre' => 'Coyame del Sotol'],
            ['estado_id' => 2, 'nombre' => 'Cuauhtémoc'],
            ['estado_id' => 2, 'nombre' => 'Cusihuiriachi'],
            ['estado_id' => 2, 'nombre' => 'Delicias'],
            ['estado_id' => 2, 'nombre' => 'Dr. Belisario Domínguez'],
            ['estado_id' => 2, 'nombre' => 'El Tule'],
            ['estado_id' => 2, 'nombre' => 'Galeana'],
            ['estado_id' => 2, 'nombre' => 'Gómez Farías'],
            ['estado_id' => 2, 'nombre' => 'Gran Morelos'],
            ['estado_id' => 2, 'nombre' => 'Guachochi'],
            ['estado_id' => 2, 'nombre' => 'Guadalupe'],
            ['estado_id' => 2, 'nombre' => 'Guadalupe y Calvo'],
            ['estado_id' => 2, 'nombre' => 'Guazapares'],
            ['estado_id' => 2, 'nombre' => 'Guerrero'],
            ['estado_id' => 2, 'nombre' => 'Hidalgo del Parral'],
            ['estado_id' => 2, 'nombre' => 'Huejotitán'],
            ['estado_id' => 2, 'nombre' => 'Ignacio Zaragoza'],
            ['estado_id' => 2, 'nombre' => 'Janos'],
            ['estado_id' => 2, 'nombre' => 'Jiménez'],
            ['estado_id' => 2, 'nombre' => 'Juárez'],
            ['estado_id' => 2, 'nombre' => 'Julimes'],
            ['estado_id' => 2, 'nombre' => 'La Cruz'],
            ['estado_id' => 2, 'nombre' => 'López'],
            ['estado_id' => 2, 'nombre' => 'Madera'],
            ['estado_id' => 2, 'nombre' => 'Maguarichi'],
            ['estado_id' => 2, 'nombre' => 'Manuel Benavides'],
            ['estado_id' => 2, 'nombre' => 'Matachí'],
            ['estado_id' => 2, 'nombre' => 'Matamoros'],
            ['estado_id' => 2, 'nombre' => 'Meoqui'],
            ['estado_id' => 2, 'nombre' => 'Morelos'],
            ['estado_id' => 2, 'nombre' => 'Moris'],
            ['estado_id' => 2, 'nombre' => 'Namiquipa'],
            ['estado_id' => 2, 'nombre' => 'Nonoava'],
            ['estado_id' => 2, 'nombre' => 'Nuevo Casas Grandes'],
            ['estado_id' => 2, 'nombre' => 'Ocampo'],
            ['estado_id' => 2, 'nombre' => 'Ojinaga'],
            ['estado_id' => 2, 'nombre' => 'Praxedis G. Guerrero'],
            ['estado_id' => 2, 'nombre' => 'Riva Palacio'],
            ['estado_id' => 2, 'nombre' => 'Rosales'],
            ['estado_id' => 2, 'nombre' => 'Rosario'],
            ['estado_id' => 2, 'nombre' => 'San Francisco de Borja'],
            ['estado_id' => 2, 'nombre' => 'San Francisco de Conchos'],
            ['estado_id' => 2, 'nombre' => 'San Francisco del Oro'],
            ['estado_id' => 2, 'nombre' => 'Santa Bárbara'],
            ['estado_id' => 2, 'nombre' => 'Santa Isabel'],
            ['estado_id' => 2, 'nombre' => 'Satevó'],
            ['estado_id' => 2, 'nombre' => 'Saucillo'],
            ['estado_id' => 2, 'nombre' => 'Temósachi'],
            ['estado_id' => 2, 'nombre' => 'El Valle de Zaragoza'],
            ['estado_id' => 2, 'nombre' => 'Urique'],
            ['estado_id' => 2, 'nombre' => 'Uruachi'],
        ];

        DB::table('cities')->insert($municipios);
    }
}
