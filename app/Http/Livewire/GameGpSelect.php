<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GameGpSelect extends Component
{

    public array $gearpieces;
    public array $skills;
    public array $gearpieceTypes = ['Head gearpieces', 'Clothes gearpieces', 'Shoes gearpieces'];
    public string $gpName;
    public string $mainSkill;
    public int $mainSkillId;

    public function mount($gearpieces = [], $skills, $gpName = 'Hed_FST000', $mainSkill = 'unknown' , $mainSkillId = 26)
    {
        $this->gearpieces = $gearpieces;
        $this->skills = $skills;
        $this->gpName = $gpName;
        $this->mainSkill = $mainSkill;
        $this->mainSkillId = $mainSkillId;
    }

    public function render()
    {
        return view('livewire.game-gp-select');
    }

    public function updateGearpiece(string $modelName)
    {
        foreach ($this->gearpieces as $gearpieceType) {
            foreach ($gearpieceType as $gearpiece) {
                if ($gearpiece['ModelName'] == $modelName) {
                    $this->gpName = $gearpiece['ModelName'];
                    $this->mainSkill = $gearpiece['Skill0'];

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
