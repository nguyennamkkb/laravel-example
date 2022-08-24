<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\EmployeeType;
use Doctrine\DBAL\Schema\Index;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ["nguyennam.kkb", "admin"];
        DB::table('users')->insert([
            'name' => $name[0],
            'email' => $name[0] . '@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        DB::table('users')->insert([
            'name' => $name[1],
            'email' =>  $name[1] . '@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
