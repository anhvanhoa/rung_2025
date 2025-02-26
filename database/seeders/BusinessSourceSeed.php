<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSourceSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_sources')->insert([
            [
                'business_id' => 1, // Ensure this business_id exists in the businesses table
                'source_id' => 1, // Ensure this source_id exists in the sources table
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_id' => 1, // Ensure this business_id exists in the businesses table
                'source_id' => 2, // Ensure this source_id exists in the sources table
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
