<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::upsert([
            ['skill_name' => 'MainInk_Save', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'SubInk_Save', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'InkRecovery_Up', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'HumanMove_Up', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'SquidMove_Up', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'SpecialIncrease_Up', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'RespawnSpecialGauge_Save', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'SpecialTime_Up', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'BombDistance_Up', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'RespawnTime_Save', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'JumpTime_Save', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'OpInkEffect_Reduction', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'BombDamage_Reduction', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'MarkingTime_Reduction', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'StartAllUp', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'EndAllUp', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'ComeBack', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'MinorityUp', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'ThermalInk', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'DeathMarking', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'Exorcist', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'SquidMoveSpatter_Reduction', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'SuperJumpSign_Hide', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'SomersaultLanding', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'ObjectEffect_Up', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'ExSkillDouble', 'is_main' => true, 'created_at' => now(), 'updated_at' => now()],
            ['skill_name' => 'Unknown', 'is_main' => false, 'created_at' => now(), 'updated_at' => now()]
        ], ['id']);
    }
}
