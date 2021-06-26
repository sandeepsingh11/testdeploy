<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Weapon extends Component
{
    public Collection $weapons;
    public Collection $specials;
    public Collection $subs;
    public string $weaponName = 'Shooter_Short_00';
    public string $specialName = 'SuperLanding';
    public string $subName = 'Bomb_Curling';
    public int $oldWeapon = -1;

    public function mount(Collection $weapons, Collection $specials, Collection $subs, int $oldWeapon = -1)
    {
        $this->weapons = $weapons;
        $this->specials = $specials;
        $this->subs = $subs;


        if ($oldWeapon != -1) {
            $this->updateWeapon($oldWeapon);
        }
    }

    public function render()
    {
        return view('livewire.weapon');
    }

    public function updateWeapon($weaponId)
    {
        // find the weapon which matches what the user selected in the select html element
        $weapon = $this->weapons->where('id', $weaponId)->first();
        $this->weaponName = $weapon->weapon_name;
        
        // update weapon special
        $this->specialName = $this->specials->where('id', $weapon->special_id)->first()->special_name;
        
        // update weapon sub
        $this->subName = $this->subs->where('id', $weapon->sub_id)->first()->sub_name;
    }
}
