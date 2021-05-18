<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GameGearSelect extends Component
{

    public array $gears;
    public array $skills;
    public array $gearTypes = ['Head gears', 'Clothes gears', 'Shoes gears'];
    public string $gearName;
    public string $mainSkill;
    public int $mainSkillId;

    public function mount($gears = [], $skills, $gearName = 'Hed_FST000', $mainSkill = 'unknown' , $mainSkillId = 26)
    {
        $this->gears = $gears;
        $this->skills = $skills;
        $this->gearName = $gearName;
        $this->mainSkill = $mainSkill;
        $this->mainSkillId = $mainSkillId;
    }

    public function render()
    {
        return view('livewire.game-gear-select');
    }

    public function updateGear(string $modelName)
    {
        foreach ($this->gears as $gearType) {
            foreach ($gearType as $gear) {
                if ($gear['ModelName'] == $modelName) {
                    $this->gearName = $gear['ModelName'];
                    $this->mainSkill = $gear['Skill0'];

                    foreach ($this->skills as $skill) {
                        if ($skill['skill'] === $this->mainSkill) {
                            $this->mainSkillId = $skill['id'];

                            break;
                        }
                    }

                    return;
                }
            }
        }
    }
}
