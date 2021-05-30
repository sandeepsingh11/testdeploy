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
     * An array of the 4 skill names.
     *
     * @var array
     */
    public $skills;

    /**
     * The user object.
     *
     * @var User
     */
    public $user;

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
     * @param  Gear  $gear
     * @param  array  $skills
     * @param  User  $user
     * @param  bool  $single
     * @return void
     */
    public function __construct($gear, $skills, $user, $single = false)
    {
        $this->gear = $gear;
        $this->skills = $skills;
        $this->user = $user;

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
        return view('components.gear.base');
    }
}
