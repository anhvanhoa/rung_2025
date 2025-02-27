<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreedSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('breeds')->insert([
            [
                'name' => 'Cam Sành',
                'type' => 'tree'
            ],
            [
                'name' => 'Xoài Cát Hòa Lộc',
                'type' => 'tree'
            ],
            [
                'name' => 'Lúa Jasmine 85',
                'type' => 'seed'
            ],
            [
                'name' => 'Dưa Hấu Không Hạt',
                'type' => 'seed'
            ],
            [
                'name' => 'Chôm Chôm Java',
                'type' => 'tree'
            ],
            [
                'name' => 'Ớt Chỉ Thiên',
                'type' => 'seed'
            ],
            [
                'name' => 'Mãng Cầu Xiêm',
                'type' => 'tree'
            ],
            [
                'name' => 'Lúa OM5451',
                'type' => 'seed'
            ]
        ]);
    }
}
