<?php

namespace App\View\Components\Gearset;

use Illuminate\View\Component;

class Base extends Component
{
    /**
     * The gearset object.
     *
     * @var Gearset
     */
    public $gearset;

    /**
     * The gears array.
     *
     * @var array
     */
    public $gears;

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
     * Boolean of whether a single gear is being displayed.
     *
     * @var bool
     */
    public $single;

    /**
     * Boolean of whether a the gear should be linked.
     *
     * @var bool
     */
    public $link;

    /**
     * Boolean of whether a the gear should have a hover effect.
     *
     * @var bool
     */
    public $hover;

    /**
     * Create a new component instance.
     *
     * @param  Gearset  $gearset
     * @param  array  $gears
     * @param  User  $user
     * @param  array  $weapons
     * @param  bool  $single
     * @return void
     */
    public function __construct($gearset, $gears, $user, $weapons, $single = false)
    {
        $this->gearset = $gearset;
        $this->gears = $gears;
        $this->user = $user;
        $this->weapons = $weapons;

        if ($single) {
            $this->link = false;
            $this->hover = false;
        }
        else {
            $this->link = true;
            $this->hover = true;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.gearset.base');
    }
}
