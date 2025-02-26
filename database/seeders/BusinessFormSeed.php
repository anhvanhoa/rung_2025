<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessFormSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_forms')->insert([
            ['name' => 'Sản xuất giống cây Lâm Nghiệp'],
            ['name' => 'Kinh doanh giống cây lâm nghiệp'],
            ['name' => 'SX các loài hoa lan'],
            ['name' => 'Sản xuất giống cây LN'],
            ['name' => 'Giống cây LN'],
            ['name' => 'Kinh doanh, chế biến gỗ'],
            ['name' => 'CB đồ Mộc'],
            ['name' => 'MB,CB'],
            ['name' => 'CB đồ Thờ'],
            ['name' => 'Nhập khẩu, mua bán, chế biến'],
            ['name' => 'Gia công, chế biến gỗ'],
            ['name' => 'Sản xuất, kinh doanh gỗ xây dựng'],
            ['name' => 'Sản xuất, kinh doanh đồ mộc'],
            ['name' => 'Kinh doanh gỗ'],
            ['name' => 'Sản xuất gỗ xây dựng'],
        ]);
    }
}
