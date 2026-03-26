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
                'phone'=>'123456'.rand(1000,9999),
                'created_at'=>date('Y-m-d h:m:s'),
                'updated_at'=>date('Y-m-d h:m:s'),
                'id_user'=>($i+1),
            ]);




        }
    }
}
