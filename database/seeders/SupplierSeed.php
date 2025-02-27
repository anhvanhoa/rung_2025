<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'name' => 'Công ty giống'
            ],
            [
                'name' => 'Thu mua từ người dân'
            ],
            [
                'name' => 'Thu hái từ rừng giống'
            ],
            [
                'name' => 'Vườn giống'
            ],
            [
                'name' => 'Tự sản xuất'
            ],
            [
                'name' => 'Các loài lan trong nước'
            ],
            [
                'name' => 'Trong nước'
            ],
            [
                'name' => 'Nhập khẩu'
            ]
        ]);
    }
}
