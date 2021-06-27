<?php

namespace Database\Seeders;

use App\Models\Special;
use Illuminate\Database\Seeder;

class SpecialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Special::upsert([
            ['special_name' => 'AquaBall', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'Jetpack', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'LauncherCurling', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'LauncherQuick', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'LauncherRobo', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'LauncherSplash', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'LauncherSuction', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'RainCloud', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'SuperArmor', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'SuperBall', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'SuperBubble', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'SuperLanding', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'SuperMissle', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'SuperStamp', 'created_at' => now(), 'updated_at' => now()],
            ['special_name' => 'WaterCutter', 'created_at' => now(), 'updated_at' => now()]
        ], ['id']);
    }
}
