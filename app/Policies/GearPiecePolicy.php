<?php

namespace App\Policies;

use App\Models\GearPiece;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GearPiecePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the current user can delete the specified gear piece.
     * 
     * @param \App\Models\User $user
     * @param \App\Models\GearPiece $gearpiece
     * 
     * @return bool
     */
    public function delete(User $user, GearPiece $gearpiece)
    {
        return $user->id === $gearpiece->user_id;
    }
}
