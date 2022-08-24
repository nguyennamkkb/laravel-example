<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PricesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $price = ["17000", "17100", "17200", "17300", "17400", "17500", "17600", "17700", "17800", "17900", "18000", "18100", "18200", "18300", "18400", "18500", "18600", "18700", "18800", "18900", "19000", "19100", "19200", "19300", "19400", "19500", "19600", "19700", "19800", "19900", "20000", "20100", "20200", "20300", "20400", "20500", "20600", "20700", "20800", "20900", "21000"];
        foreach ($price as $value2) {
            DB::table('prices')->insert(
                [
                    'name' => $value2,
                ]
            );
        }
    }
}
