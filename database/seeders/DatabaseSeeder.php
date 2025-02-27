<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DistrictSeed::class,
            CommuneSeed::class,
            BusinessTypeSeed::class,
            BusinessFormSeed::class,
            PeopleSeed::class,
            BusinessSeed::class,
            SourceSeed::class,
            BusinessSourceSeed::class,
            BusinessBusinessFormSeeder::class,
            BreedSeed::class,
            SupplierSeed::class,
            TechnologySeed::class,
        ]);
    }
}
