<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class ClientsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=2;$i<10;$i++){
            DB::table('users')->insert([
                'name'=>'Cliente '.($i+1),
                'email'=>'c'.($i+1).'@gmail.com',
                'password'=>Hash::make('452500'),
                'img'=>'default.jpg',
                'level'=> 3,
                'created_at'=>date('Y-m-d h:m:s'),
                'updated_at'=>date('Y-m-d h:m:s'),
            ]);
            DB::table('clients')->insert([
                'rfc'=>'FAKE'.rand(1000,10000).'RFC'.($i+1),
                'address'=>'Calle tal #',
                'lat'=>'',
                'lng'=>'',
                'balance'=>rand(100,25000),
                'phone'=>'123456'.rand(1000,9999),
                'created_at'=>date('Y-m-d h:m:s'),
                'updated_at'=>date('Y-m-d h:m:s'),
                'id_user'=>($i+1),
            ]);

            DB::table('addresses')->insert([
                'phone'=>'51111'.rand(1000,9999),
                'street'=>'Domicilio de recolección falso',
                'between_streets'=>'Entre calle 1 y 2 ',
                'exterior_number'=>rand(1000,9999),
                'interior_number'=>'',
                'city'=>'Monterrey',
                'state'=>'Nuevo Leon',
                'reference'=>'Tienda de abarrotes',
                'zip'=>23123,
                'lat'=>'',
                'lng'=>'',
                'type'=>'from',
                'created_at'=>date('Y-m-d h:m:s'),
                'updated_at'=>date('Y-m-d h:m:s'),
                'id_client'=>($i-1),
                'is_default'=>true
            ]);
            DB::table('addresses')->insert([
                'phone'=>'51111'.rand(1000,9999),
                'street'=>'Domicilio de entrega falso',
                'between_streets'=>'Entre calle 1 y 2 ',
                'exterior_number'=>rand(1000,9999),
                'interior_number'=>'',
                'city'=>'Monterrey',
                'state'=>'Nuevo Leon',
                'reference'=>'Casa azul',
                'zip'=>23123,
                'lat'=>'',
                'lng'=>'',
                'type'=>'to',
                'created_at'=>date('Y-m-d h:m:s'),
                'updated_at'=>date('Y-m-d h:m:s'),
                'id_client'=>($i-1),
                'is_default'=>true
            ]);

        }
    }
}
