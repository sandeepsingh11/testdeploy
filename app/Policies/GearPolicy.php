<?php

namespace App\Policies;

use App\Models\Gear;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GearPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the current user can delete the specified gear piece.
     * 
     * @param \App\Models\User $user
     * @param \App\Models\Gear $gear
     * 
     * @return bool
     */
    public function delete(User $user, Gear $gear)
    {
        return $user->id === $gear->user_id;
    }
}
