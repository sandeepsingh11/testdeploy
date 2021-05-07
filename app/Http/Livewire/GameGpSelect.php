<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GameGpSelect extends Component
{

    public array $gearpieces;
    public array $skills;
    public array $gearpieceTypes = ['Head gearpieces', 'Clothes gearpieces', 'Shoes gearpieces'];
    public string $gpName = 'Hed_CAP000';
    public string $gpSkill = 'unknown';
    public int $gpSkillId = 26;

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
                    $this->gpSkill = $gearpiece['Skill0'];

                    foreach ($this->skills as $skill) {
                        if ($skill['skill'] === $this->gpSkill) {
                            $this->gpSkillId = $skill['id'];

                            break;
                        }
                    }

                    return;
                }
            }
        }
    }
}
