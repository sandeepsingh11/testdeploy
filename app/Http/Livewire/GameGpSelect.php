<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GameGpSelect extends Component
{

    public array $gearpieces;
    public array $skills;
    public array $gearpieceTypes = ['Head gearpieces', 'Clothes gearpieces', 'Shoes gearpieces'];
    public string $gpName = 'Hed_FST000';
    public string $mainSkill = 'unknown';
    public int $mainSkillId = 26;

    public function mount($gearpieces, $skills)
    {
        $this->gearpieces = $gearpieces;
        $this->skills = $skills;
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
