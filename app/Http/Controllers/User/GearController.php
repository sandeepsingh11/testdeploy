<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GearAbstractController;
use App\Models\User;
use Illuminate\Http\Request;

class GearController extends Controller
{
    public function __construct()
    {
        // user must be logged in to view, otherwise redirect
        $this->middleware(['auth']);
    }

    public function create(User $user)
    {
        // get user's gear pieces
        $userGearPieces = $user->gearpieces;

        // get splatdata
        $splatdata = GearAbstractController::getSplatdata();
        // dd($splatdata[4][0]);
        // dd($userGearPieces);

        return view('users.gear.create', [
            'user' => $user,
            'gearpieces' => $userGearPieces,
            'splatdata' => $splatdata,
        ]);
    }

    public function store(User $user, Request $request)
    {
        dd($request);
    }
}
