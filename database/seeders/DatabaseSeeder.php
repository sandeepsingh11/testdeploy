<?php

namespace Database\Seeders;

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
            // populate required data
            SubsTableSeeder::class,
            SpecialsTableSeeder::class,
            SkillsTableSeeder::class,
            WeaponsTableSeeder::class,
            BaseGearsTableSeeder::class,
            // generate dummy data
            DummySeeder::class
        ]);
    }
}
