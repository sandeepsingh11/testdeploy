<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class BaseGearSelect extends Component
{

    public Collection $gears;
    public Collection $skills;
    public array $gearTypesDisplay = ['Head gears', 'Clothes gears', 'Shoes gears'];
    public array $gearTypes = ['H', 'C', 'S'];
    public string $gearName;
    public string $mainSkill;
    public int $mainSkillId;

    public function mount($gears, $skills, $gearName = 'Hed_FST000', $mainSkill = 'InkRecovery_Up' , $mainSkillId = 26)
    {
        $this->gears = $gears;
        $this->skills = $skills;
        $this->gearName = $gearName;
        $this->mainSkill = $mainSkill;
        $this->mainSkillId = $mainSkillId;
    }

    public function render()
    {
        return view('livewire.base-gear-select');
    }

    public function updateGear(int $gearId)
    {
        foreach ($this->gears as $gear) {
            if ($gear->id === $gearId) {
                $this->gearName = $gear->base_gear_name;
                
                $this->mainSkillId = $gear->main_skill_id;
                $thisSkill = $this->skills->find($this->mainSkillId);
                $this->mainSkill = $thisSkill->skill_name;

                return;
            }
        }
    }
}
