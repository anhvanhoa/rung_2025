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
                'code' => 'D001',
                'name' => 'District 1',
                'longitude' => 123456,
                'latitude' => 654321,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D002',
                'name' => 'District 2',
                'longitude' => 123457,
                'latitude' => 654322,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D003',
                'name' => 'District 3',
                'longitude' => 123458,
                'latitude' => 654323,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
