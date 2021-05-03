<?php

namespace Database\Seeders;

use App\Models\Gear;
use App\Models\GearPiece;
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
                Gear::factory()
                    ->count(5)
                    ->hasAttached(
                        GearPiece::factory()
                            ->count(3)
                            ->state(new Sequence(
                                ['gear_piece_type' => 'h'],
                                ['gear_piece_type' => 'c'],
                                ['gear_piece_type' => 's'],
                            ))
                            ->state(function (array $attributes, Gear $gear) {
                                return ['user_id' => $gear->user_id];
                            })
                    )
            )
            ->create();
    }
}
