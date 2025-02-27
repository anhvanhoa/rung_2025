<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([
            [
                'code' => 'H001',
                'name' => 'Ba Vì',
                'longitude' => 105.4231,
                'latitude' => 21.1391,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'H002',
                'name' => 'Đan Phượng',
                'longitude' => 105.6782,
                'latitude' => 21.0817,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'H003',
                'name' => 'Hoài Đức',
                'longitude' => 105.7324,
                'latitude' => 20.9981,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'H004',
                'name' => 'Mê Linh',
                'longitude' => 105.7103,
                'latitude' => 21.1796,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'H006',
                'name' => 'Thạch Thất',
                'longitude' => 105.5502,
                'latitude' => 20.9964,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'H007',
                'name' => 'Thanh Trì',
                'longitude' => 105.8372,
                'latitude' => 20.9025,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'H008',
                'name' => 'Ứng Hòa',
                'longitude' => 105.7834,
                'latitude' => 20.6815,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

    }
}
