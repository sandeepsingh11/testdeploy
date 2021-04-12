<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GearPieceController extends Controller
{
    public function index(User $user)
    {
        // $gearpieces = $user->gearpieces()->with(['user', 'likes'])->paginate(20);

        return view('users.gear-pieces.index', [
            'user' => $user,
            // 'gear-pieces' => $gearpieces
        ]);
    }

    public function show(User $user) // GearPiece $gearpiece
    {
        return view('users.gear-piece.show', [
            'user' => $user,
            'gear-piece' => $user // $gearpiece
        ]);
    }
}
