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
            [
                'code' => 'C001',
                'name' => 'Commune 1',
                'longitude' => 123456,
                'latitude' => 654321,
                'district_code' => 'D001',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'C002',
                'name' => 'Commune 2',
                'longitude' => 123457,
                'latitude' => 654322,
                'district_code' => 'D001',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'C003',
                'name' => 'Commune 3',
                'longitude' => 123458,
                'latitude' => 654323,
                'district_code' => 'D002',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'C004',
                'name' => 'Commune 4',
                'longitude' => 123459,
                'latitude' => 654324,
                'district_code' => 'D002',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
