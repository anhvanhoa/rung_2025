<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'name' => 'Nhà cung cấp 1'
            ],
            [
                'name' => 'Nhà cung cấp 2'
            ],
            [
                'name' => 'Nhà cung cấp 3'
            ],
            [
                'name' => 'Nhà cung cấp 4'
            ],
            [
                'name' => 'Nhà cung cấp 5'
            ],
        ]);
    }
}
