<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(UsersSeeder::class);
        $this->call(ClientsSeeders::class);
        $this->call(PaymentSeeder::class);
        $this->call(ZonesSeeder::class);
        $this->call(RegionsSeeder::class);
        $this->call(PricesSeeder::class);
        $this->call(AttributesSeeder::class);
        $this->call(PackagesSeeder::class);
        $this->call(RoutesSeeder::class);
        
    }
}
