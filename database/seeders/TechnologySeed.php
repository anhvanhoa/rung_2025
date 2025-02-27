<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnologySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('technologies')->insert([
            [
                'name' => 'Thủ công',
                'type' => 'irrigation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bán tự động',
                'type' => 'irrigation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tự động',
                'type' => 'irrigation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vườn ươm truyền thống',
                'type' => 'nursery',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nhà lưới',
                'type' => 'nursery',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nhà màng',
                'type' => 'nursery',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
