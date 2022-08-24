<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //customer_types
        $index = 0;
        $customer_types =
            [
                "Bán vầu" => ["Hiền lợi", "Toàn Linh", "Tuấn anh ", "Tuyết nghị", "Hà tùng", "", "Trịnh diệu", "Tâm thắng", "Thơm thụ", "Mua dao", "Tưởng tâm", "Đông ngát", "mười", "quy hop", "hà na", "luong bang", "hang trinh"],
                "Bán tăm" => ["Ánh đại", "Ánh trung", "Ánh Tuấn", "Bằng hậu", "Bích dũng", "Bích trọng", "bình đạt", "Bình luật ", "Bình tiến", "bộ sáng", "Bường cảnh", "Cảnh hà", "Châu Vi", "chị tước", "Chính hải", "Cô đường ", "Cúc trung", "Diêu Trinh", "Dịu Bổng", "Dũng bích", "Dung chính", "Dung lin", "Dung luận", "Đại Gấm", "Điểm mạnh", "Đoán bd", "Đông ngát ", "Đức Hồng", "Đức ngọc", "Giang Triển", "giỏi", "Gọn phục ", "Hà na", "Hà thụ", "Hải phượng", "Hạnh Sự", "Hằng đạt", "Hằng quang", "Hằng Thông", "Hậu hoàn", "Hiền lợi", "Hoa đạt", "Hòa Khơi", "Hoàng tâm", "hồng toàn", "Hồng tuấn", "Huệ thắng", "hùng sơn cb", "Hùng xiểng", "huong dat", "Huy yến", "Hưng huê", "Hương Hiền", "Hương Vinh", "Hương vương", "Khuyên Phiến", "Khuyên tuyển", "Kiên hồng", "Kiên mưa", "Kiên ngân", "là phi", "lan hiền", "lan oai", "Lan quân ", "Lan trà", "Lê hiểu", "Lí tùng", "Liên lịch", "Lo nền", "loan hải", "loan may", "Lợi Sao", "Luận dung", "Mai Sinh", "Mận Đạo", "minh giang", "Minh nghinh", "Minh quang", "Na thắng ", "Nga đạt", "Nghĩa mao", "Nhân kiên", "Nhiên tháng bd", "Nhung hậu", "Oanh hiệu", "Phúc hưng", "phúc xi đa", "hương đạt pt", "", "Quang Thương", "quý hợp", "Quý san", "Quyền bd", "Quỳnh hà", "Sáu li pt", "sáu nghị", "Sắc trọng", "Sức Hiền", "Sửu hoà", "Tâm Điệp", "tâm trường ", "Tấn Luyên", "Tần Ngàn", "Thanh hiển", "Thanh hiệp", "Thanh sỉnh", "Thảo cương", "Thảo kiên", "thắng sơn", "Tho đạt", "Thoa đảng", "Thông minh", "Thơm thụ", "Thu Huy", "thủy quang", "Thư xuất", "Tiến luyến ", "tính oanh", "Trang phượng", "Trang sự", "Trâm trình", "trí hải ", "Trí trọng", "Tuyết tú", "Tuyết Tuấn", "Tư chinh", "Tranh tăm vuông", "vạn", "Vân anh", "Vân tiến", "Vĩ ba dư", "Viên xuyến", "Vĩnh bản mèo", "Vĩnh pt", "Vĩnh Yên", "Vui  duy", "vung", "Xa di", "Xi đa đượm", "Xuân Hải", "Xuân Tính", "Yến Nguyện", "khánh hđ", "út vinh", "tuấn thỏa", "tưởng tâm", "nhân hiền", "ánh nam", "xen hoạt", "loan an", "quỳnh cheng", "chị hương", "toan bảo", "Nga tình", "Thể", "Hà chính"],
                "Mua tăm" => ["Bán vặt","Anh Ba","Dung Đà Nẵng DN","Trang Cần Thơ CT","Quang Sài Gòn SG","Thư Sài Gòn SG","Trang Sài Gòn SG","Sang Sài Gòn SG","Yến Sài Gòn SG","A Thuận Sài gòn SG","Toan Đà Nẵng DN","Thống","Vân Đà Nẵng DN","Huynh","Duc Đà Nẵng DN","Lieu Long An LA","Loan Cầu Lác"]
            ];
        foreach ($customer_types as $key => $value) {
            $index++;
            DB::table('customer_types')->insert(
                [
                    'name' => $key,
                ]
            );
            foreach ($value as $value2) {
                if (!empty($value2)) {
                    DB::table('customers')->insert(
                        [
                            'customerType_id' => $index,
                            'name' => $value2,
                        ]
                    );
                }
            }
        }
    }
}
