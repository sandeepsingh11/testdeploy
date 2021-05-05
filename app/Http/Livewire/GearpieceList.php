<?php

namespace App\Http\Livewire;

use App\Http\Controllers\GearAbstractController;
use Livewire\Component;

class GearpieceList extends Component
{

    public array $headData;
    public array $clothesData;
    public array $shoesData;
    public array $gpList = [];

    public function mount()
    {
        $this->headData = GearAbstractController::getSplatdata('Head');
        $this->clothesData = GearAbstractController::getSplatdata('Clothes');
        $this->shoesData = GearAbstractController::getSplatdata('Shoes');

        $this->gpList = $this->headData;
    }

    public function render()
    {
        return view('livewire.gearpiece-list');
    }

    public function updateGpList($gpType)
    {
        if ($gpType == 'h') {
            $this->gpList = $this->headData;
        }
        else if ($gpType === 'c') {
            $this->gpList = $this->clothesData;
        }
        else if ($gpType === 's') {
            $this->gpList = $this->shoesData;
        }
    }
}
