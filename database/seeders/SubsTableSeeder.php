<?php

namespace Database\Seeders;

use App\Models\Sub;
use Illuminate\Database\Seeder;

class SubsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sub::upsert([
            ['sub_name' => 'Bomb_Curling', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'Bomb_Piyo', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'Bomb_Quick', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'Bomb_Robo', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'Bomb_Splash', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'Bomb_Suction', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'Bomb_Tako', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'Flag', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'PointSensor', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'PoisonFog', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'Shield', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'Sprinkler', 'created_at' => now(), 'updated_at' => now()],
            ['sub_name' => 'TimerTrap', 'created_at' => now(), 'updated_at' => now()]
        ], ['id']);
    }
}
