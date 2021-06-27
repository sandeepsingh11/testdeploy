<?php

namespace Database\Seeders;

use App\Models\BaseGear;
use App\Models\Gearset;
use App\Models\Gear;
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
     * Assoc array of gear types.
     * 
     * @var array
     */
    public $gearTypes = [0 => 'H', 1 => 'C', 2 => 'S'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(5)
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
                            ->state(function (array $attributes, Gearset $gearset) {
                                return ['user_id' => $gearset->user_id];
                            }),
                    )
            )
            ->create();
    }
}
