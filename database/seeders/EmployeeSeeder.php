<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //employee
        $index=0;
        $employee_types = [
            "Đóng kiện" => ["Nguyễn Xuân Định"],
            "Cắt tăm" => ["Tiến"],
            "Kiểm tra" => ["Nguyễn Lương Nam", "Nguyễn Lương Thực", "Nguyễn Thị Mười", "Nguyễn Thị Phương", "Người Lạ", "Cân điện tử"],
            "Vận chuyển" => ["Lê Văn Minh", "Người lạ"],
            "Máy lọc" => []
        ];
        foreach ($employee_types as $key => $value) {
            $index++;
            DB::table('employee_types')->insert(
                [
                    'name' => $key,
                ]
            );
            foreach ($value as $value2) {
                if (!empty($value2)) {
                    DB::table('employees')->insert(
                        [
                            'employeeType_id' => $index,
                            'name' => $value2,
                        ]
                    );
                }
            }
        }
    }
}
