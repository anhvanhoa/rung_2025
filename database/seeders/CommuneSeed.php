<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommuneSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('communes')->insert([
            // Xã thuộc huyện Ba Vì
            [
                'code' => 'X001',
                'name' => 'Tây Đằng',
                'longitude' => 105.4231,
                'latitude' => 21.1387,
                'district_code' => 'H001',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'X002',
                'name' => 'Chu Minh',
                'longitude' => 105.4321,
                'latitude' => 21.1290,
                'district_code' => 'H001',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Xã thuộc huyện Đan Phượng
            [
                'code' => 'X003',
                'name' => 'Tân Hội',
                'longitude' => 105.6782,
                'latitude' => 21.0810,
                'district_code' => 'H002',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'X004',
                'name' => 'Liên Trung',
                'longitude' => 105.6825,
                'latitude' => 21.0745,
                'district_code' => 'H002',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Xã thuộc huyện Hoài Đức
            [
                'code' => 'X005',
                'name' => 'An Khánh',
                'longitude' => 105.7324,
                'latitude' => 20.9981,
                'district_code' => 'H003',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'X006',
                'name' => 'Song Phương',
                'longitude' => 105.7400,
                'latitude' => 20.9950,
                'district_code' => 'H003',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Xã thuộc huyện Mê Linh
            [
                'code' => 'X007',
                'name' => 'Tiến Thắng',
                'longitude' => 105.7103,
                'latitude' => 21.1800,
                'district_code' => 'H004',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'X008',
                'name' => 'Tráng Việt',
                'longitude' => 105.7152,
                'latitude' => 21.1723,
                'district_code' => 'H004',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
