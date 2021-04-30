<?php

namespace App\View\Components\Gear;

use Illuminate\View\Component;

class Base extends Component
{
    /**
     * The gear object.
     *
     * @var Gear
     */
    public $gear;

    /**
     * The gearpieces array.
     *
     * @var array
     */
    public $gearpieces;

    /**
     * The user object.
     *
     * @var User
     */
    public $user;

    /**
     * The weapons array.
     *
     * @var array
     */
    public $weapons;

    /**
     * Create a new component instance.
     *
     * @param  Gear  $gear
     * @param  array  $gearpieces
     * @param  User  $user
     * @param  array  $weapons
     * @return void
     */
    public function __construct($gear, $gearpieces, $user, $weapons)
    {
        $this->gear = $gear;
        $this->gearpieces = $gearpieces;
        $this->user = $user;
        $this->weapons = $weapons;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.gear.base');
    }
}
