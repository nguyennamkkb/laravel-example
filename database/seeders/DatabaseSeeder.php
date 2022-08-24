<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\Employee_type;
use Database\Seeders\CustomersSeeder;
use Database\Seeders\CategorySeed;
use Database\Seeders\PricesSeed;




class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            EmployeeSeeder::class,
            CustomersSeeder::class,
            CategorySeed::class,
            PricesSeed::class,
        ]);
    }
}
