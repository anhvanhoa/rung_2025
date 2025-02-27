<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            "name" => "Admin",
            "email" => "admin@gmail.com",
            "password" => bcrypt("123456")
        ]);
    }
}
