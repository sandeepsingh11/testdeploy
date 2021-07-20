<?php

namespace Database\Seeders;

use App\Models\BaseGear;
use App\Models\Gearset;
use App\Models\Gear;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Counter.
     * 
     * @var int
     */
    public $i = 0;

    /**
     * Counter.
     * 
     * @var int
     */
    public $j = 0;

    /**
     * Assoc array of gear types.
     * 
     * @var array
     */
    public $gearTypes = [0 => 'H', 1 => 'C', 2 => 'S'];

    /**
     * Assoc array of skill types.
     * 
     * @var array
     */
    public $skillTypes = [0 => 'Main', 1 => 'Sub1', 2 => 'Sub2', 3 => 'Sub3'];

    /**
     * Assoc array of skill types.
     * 
     * @var string
     */
    public $skillType;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(3)
            ->has(
                Gearset::factory()
                    ->count(3)
                    ->hasAttached(
                        Gear::factory()
                            ->count(3) // keep this at 3 to associate 3 gears to a gearset
                            ->state(new Sequence(
                                // sequence to make each gear type
                                
                                function() {
                                    // gear type via Base Gears 
                                    // (otherwise it populates a non existant gear_type field within Gear)

                                    $baseGears = BaseGear::factory()
                                        ->count(1) // keep this at 1 to make the current gear type
                                        ->state(new Sequence(
                                            ['base_gear_type' => $this->gearTypes[$this->i]]
                                        ))
                                        ->make();

                                    // counter for Sequence to loop through $this->gearTypes
                                    $this->i++;
                                    if ($this->i > 2) $this->i = 0;

                                    return ['base_gear_id' => $baseGears[0]->id];
                                }
                            ))
                            ->hasAttached(
                                Skill::factory()
                                    ->count(4)
                                    ->make()
                                , function() {
                                    // Cannot get state -> Sequence to work like BaseGears above. Only iterates through 4 skills once,
                                    // So a hack is to compute from a call back function, like so:
                                    // https://stackoverflow.com/questions/64303672/how-to-seed-multiple-many-to-many-relationships-with-different-pivot-data-in-lar

                                    // loop through ['Main', 'Sub1', 'Sub2', 'Sub3']
                                    $this->skillType = $this->skillTypes[$this->j];
                                    
                                    // counter to loop through $this->skillTypes
                                    $this->j++;
                                    if ($this->j > 3) $this->j = 0;



                                    // main exclusive skill or general skill
                                    $isMain = false;
                                    if ($this->skillType === 'Main') $isMain = true;

                                    $skill = Skill::all()->except(27)->where('is_main', $isMain)->random();



                                    return ['skill_type' => $this->skillType, 'skill_id' => $skill->id]; // pivot attribute
                                }
                            )
                            ->state(function (array $attributes, Gearset $gearset) {
                                return ['user_id' => $gearset->user_id];
                            }),
                    )
            )
            ->create();
    }
}
