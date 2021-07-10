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

    public function mount($gears, $skills, $gearName = 'Hed_FST000', $mainSkill = 'InkRecovery_Up' , $mainSkillId = 27)
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
        $selectedGear = $this->gears->where('id', $gearId)->first();

        $this->gearName = $selectedGear->base_gear_name;
        $this->mainSkillId = $selectedGear->main_skill_id;
        $this->mainSkill = $this->skills->where('id', $this->mainSkillId)->first()->skill_name;
    }
}
