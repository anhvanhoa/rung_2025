<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('businesses')->insert([
            [
                'id' => 1,
                'name' => 'Công ty 1',
                'business_registration' => 'BR123456',
                'tax_code' => 'TC123456',
                'annual_revenue' => 1000000,
                'average_consumption' => 50000,
                'workers_no_qual' => 10,
                'workers_deg' => 5,
                'female_workers' => 7,
                'male_workers' => 8,
                'longitude' => 123456,
                'latitude' => 654321,
                'business_type_id' => 1, // Ensure this business_type_id exists in the business_types table
                'commune_code' => 'X002', // Ensure this commune_code exists in the communes table
                'owner_id' => 1, // Ensure this owner_id exists in the people table
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Công ty 2',
                'business_registration' => 'BR654321',
                'tax_code' => 'TC654321',
                'annual_revenue' => 2000000,
                'average_consumption' => 100000,
                'workers_no_qual' => 20,
                'workers_deg' => 10,
                'female_workers' => 14,
                'male_workers' => 16,
                'longitude' => 654321,
                'latitude' => 123456,
                'business_type_id' => 2, // Ensure this business_type_id exists in the business_types table
                'commune_code' => 'X008', // Ensure this commune_code exists in the communes table
                'owner_id' => 2, // Ensure this owner_id exists in the people table
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
