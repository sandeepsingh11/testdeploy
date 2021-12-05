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
    public array $searchable;
    public array $filteredList;
    public string $searchTerm = '';

    public function mount($gears, $skills, $gearName = 'Hed_FST000', $mainSkill = 'InkRecovery_Up' , $mainSkillId = 27)
    {
        // transform gear records into array, then translate
        $this->searchable = array_column($gears->toArray(), "base_gear_name", "id");
        foreach ($this->searchable as $key => $value) {
            $this->searchable[$key] = __($value);
        }

        $this->filteredList = $this->searchable;
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

    public function selectUpdate(int $gearId)
    {
        $selectedGear = $this->gears->where('id', $gearId)->first();

        $this->gearName = $selectedGear->base_gear_name;
        $this->mainSkillId = $selectedGear->main_skill_id;
        $this->mainSkill = $this->skills->where('id', $this->mainSkillId)->first()->skill_name;
    }

    public function search()
    {
        if ($this->searchTerm != '') {
            $this->filteredList = array_filter($this->searchable, function($k) {
                return (str_contains(strtolower(__($k)), strtolower($this->searchTerm)));
            });
        }
        else {
            $this->filteredList = $this->searchable;
        }
    }
}
