<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GearAbstractController;
use App\Models\GearPiece;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class GearPieceController extends GearAbstractController
{
    public function index(User $user)
    {
        // get user's gear pieces
        $gearpieces = $user->gearpieces;
        // $gearpieces = $user->gearpieces()->with(['user'])->paginate(20);


        // dd(GearAbstractController::getSplatdata('Skills'));


        return view('users.gear-pieces.index', [
            'user' => $user,
            'gearpieces' => $gearpieces,
        ]);
    }

    public function show(User $user, GearPiece $gearpiece)
    {
        // get specified gearpiece passed from uri
        $gearpiece = $user->gearpieces->where('id', $gearpiece->id)->first();
        
        return view('users.gear-pieces.show', [
            'user' => $user,
            'gearpiece' => $gearpiece
        ]);
    }

    public function create(User $user)
    {
        // get according splatdata
        $headData = GearAbstractController::getSplatdata('Head');
        $clothesData = GearAbstractController::getSplatdata('Clothes');
        $shoesData = GearAbstractController::getSplatdata('Shoes');
        $skillsData = GearAbstractController::getSplatdata('Skills');

        $gearpieces = [
            $headData, 
            $clothesData, 
            $shoesData
        ];


        return view('users.gear-pieces.create', [
            'user' => $user,
            'gearpieces' =>$gearpieces,
            'skillsData' => $skillsData,
        ]);
    }

    public function destroy(User $user, GearPiece $gearpiece)
    {
        // check if the current user can delete the specified gear piece
        $this->authorize('delete', $gearpiece);

        // delete this model instance
        $gearpiece->delete();

        return back();
    }
}
