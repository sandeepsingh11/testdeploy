<?php

namespace App\Http\Livewire;

use App\Http\Controllers\GearAbstractController;
use Livewire\Component;

class GearList extends Component
{

    public array $headData;
    public array $clothesData;
    public array $shoesData;
    public array $gearList = [];

    public function mount()
    {
        $this->headData = GearAbstractController::getSplatdata('Head');
        $this->clothesData = GearAbstractController::getSplatdata('Clothes');
        $this->shoesData = GearAbstractController::getSplatdata('Shoes');

        $this->gearList = $this->headData;
    }

    public function render()
    {
        return view('livewire.gear-list');
    }

    public function updateGearList($gearType)
    {
        if ($gearType == 'h') {
            $this->gearList = $this->headData;
        }
        else if ($gearType === 'c') {
            $this->gearList = $this->clothesData;
        }
        else if ($gearType === 's') {
            $this->gearList = $this->shoesData;
        }
    }
}
