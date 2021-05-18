<?php

namespace Database\Seeders;

use App\Models\Gearset;
use App\Models\Gear;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        User::factory()
            ->count(10)
            ->has(
                Gearset::factory()
                    ->count(5)
                    ->hasAttached(
                        Gear::factory()
                            ->count(3)
                            ->state(new Sequence(
                                ['gear_type' => 'h'],
                                ['gear_type' => 'c'],
                                ['gear_type' => 's'],
                            ))
                            ->state(function (array $attributes, Gearset $gearset) {
                                return ['user_id' => $gearset->user_id];
                            })
                    )
            )
            ->create();
    }
}
