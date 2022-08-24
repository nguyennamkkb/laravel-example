<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $index = 0;
        $category =
            [
                "Tăm cây" => ["Kiện","Công 20","Công 23","Loại 101","Loại 101 l3","Loại 102","Loại 105","loai 107 l2","Loại 107 li3","Loại 109","Loại 113","loai 42","loai 45","loai 47","loai 51","loai 53","Loại 54","loai 57","loai 59,5","loai 63","loai 66","loai 68","Loại 68 li2","loai 71","Loại 73","loai 75","Loại 76","loai 77 li2","loai 77li 3","loai 81","Loại 83,5","Loại 86,5","loai 88","loai 91","loai 94","loai 96","Loại 98 li2","Loại 98li 3"],
                "Tăm kiện" => ["Kiện"],
                "Vầu" => ["Vầu"],

            ];
        foreach ($category as $key => $value) {
            $index++;
            DB::table('categories')->insert(
                [
                    'name' => $key,
                ]
            );
            foreach ($value as $value2) {
                if (!empty($value2)) {
                    DB::table('category__children')->insert(
                        [
                            'category_id' => $index,
                            'name' => $value2,
                        ]
                    );
                }
            }
        }
    }
}
