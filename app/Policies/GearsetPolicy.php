<?php

namespace App\Policies;

use App\Models\Gearset;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GearsetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the current user can delete the specified gearset.
     * 
     * @param \App\Models\User $user
     * @param \App\Models\Gearset $gearset
     * 
     * @return bool
     */
    public function delete(User $user, Gearset $gearset)
    {
        return $user->id === $gearset->user_id;
    }
}
