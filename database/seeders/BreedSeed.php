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
                'name' => 'SEED 1',
                'type' => 'seed'
            ],
            [
                'name' => 'TREE 2',
                'type' => 'tree'
            ],
            [
                'name' => 'SEED 3',
                'type' => 'seed'
            ],
            [
                'name' => 'TREE 4',
                'type' => 'tree'
            ],
        ]);
    }
}
