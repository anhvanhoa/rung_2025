<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessBusinessFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy danh sách các business_id và business_type_id từ database
        $businesses = DB::table('businesses')->pluck('id')->toArray();
        $businessForms = DB::table('business_forms')->pluck('id')->toArray();

        // Đảm bảo có dữ liệu trước khi seed
        if (empty($businesses) || empty($businessForms)) {
            return;
        }

        $data = [];
        foreach ($businesses as $businessId) {
            // Chọn ngẫu nhiên 1-3 business_types cho mỗi business
            $randomTypes = array_rand(array_flip($businessForms), rand(1, 3));

            foreach ((array) $randomTypes as $typeId) {
                $data[] = [
                    'business_id' => $businessId,
                    'business_form_id' => $typeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Chèn dữ liệu vào bảng business_business_type
        DB::table('business_business_form')->insert($data);
    }
}
