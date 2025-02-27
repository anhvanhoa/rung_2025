<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_types')->insert([
            ['name' => 'Doanh nghiệp vừa và nhỏ'],
            ['name' => 'Cá nhân, hộ kinh doanh cá thể'],
            ['name' => 'Công ty TNHH một thành viên'],
            ['name' => 'Công ty TNHH hai thành viên trở lên'],
            ['name' => 'Công ty cổ phần'],
            ['name' => 'Doanh nghiệp tư nhân'],
            ['name' => 'Hợp tác xã'],
            ['name' => 'Công ty có vốn đầu tư nước ngoài'],
        ]);
    }
}
