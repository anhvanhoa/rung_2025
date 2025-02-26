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
            ['name' => 'Manufacturing'],
            ['name' => 'Service'],
        ]);
    }
}
