<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'name'=>'Administrador',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('452500'),
            'img'=>'default.jpg',
            'level'=> 1,
            'created_at'=>date('Y-m-d h:m:s'),
            'updated_at'=>date('Y-m-d h:m:s'),
        ]);
        DB::table('users')->insert([
            'name'=>'Repartidor 1',
            'email'=>'r1@gmail.com',
            'password'=>Hash::make('452500'),
            'img'=>'default.jpg',
            'level'=> 2,
            'created_at'=>date('Y-m-d h:m:s'),
            'updated_at'=>date('Y-m-d h:m:s'),
        ]);
        DB::table('users')->insert([
            'name'=>'Repartidor 2',
            'email'=>'r2@gmail.com',
            'password'=>Hash::make('452500'),
            'img'=>'default.jpg',
            'level'=> 2,
            'created_at'=>date('Y-m-d h:m:s'),
            'updated_at'=>date('Y-m-d h:m:s'),
        ]);
        
        
    }
}
