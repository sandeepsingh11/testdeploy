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

    public function store(Request $request, User $user)
    {
        // dd($request);

        $this->validate($request, [
            'gear-name' => 'max:256|alpha_num|nullable',
            'gear-desc' => 'max:512|alpha_num|nullable',
            'gear-mode-rm' => 'boolean',
            'gear-mode-cb' => 'boolean',
            'gear-mode-sz' => 'boolean',
            'gear-mode-tc' => 'boolean',
            'gear-weapon-id' => 'numeric|nullable',
            'gear-piece-h-id' => 'numeric|nullable',
            'gear-piece-c-id' => 'numeric|nullable',
            'gear-piece-s-id' => 'numeric|nullable',
        ]);

        // if pre-existing gp was not selected, set to null
        ($request->input('gear-head-id') == -1) ? $headId = NULL : $headId = $request->input('gear-head-id');
        ($request->input('gear-clothes-id') == -1) ? $clothesId = NULL : $clothesId = $request->input('gear-clothes-id');
        ($request->input('gear-shoes-id') == -1) ? $shoesId = NULL : $shoesId = $request->input('gear-shoes-id');

        $request->user->gears()->create([
            'gear_name' => $request->input('gear-name'),
            'gear_desc' => $request->input('gear-desc'),
            'gear_mode_rm' => $request->boolean('gear-mode-rm'),
            'gear_mode_cb' => $request->boolean('gear-mode-cb'),
            'gear_mode_sz' => $request->boolean('gear-mode-sz'),
            'gear_mode_tc' => $request->boolean('gear-mode-tc'),
            'gear_weapon_id' => $request->input('gear-weapon-id'),
            'gear_piece_h_id' => $headId,
            'gear_piece_c_id' => $clothesId,
            'gear_piece_s_id' => $shoesId,
        ]);

        return back();
    }
}
