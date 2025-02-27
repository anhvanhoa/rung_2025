<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeopleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('people')->insert([
            [
                'id' => 1,
                'name' => 'Phạm Thế Dương',
                'phone' => '123-456-7890',
                'gender' => 'male',
                'date_of_birth' => '1990-01-01',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Trịnh Trần Phương Tuấn',
                'phone' => '987-654-3210',
                'gender' => 'female',
                'date_of_birth' => '1992-02-02',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
