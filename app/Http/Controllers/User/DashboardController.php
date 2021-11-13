<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gear;
use App\Models\Gearset;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // user must be logged in to view, otherwise redirect
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $gears = $user->getRecentGears();
        $gearsets = $user->getRecentGearsets();

        $headCount = $user->getUserGearCount('H');
        $clothesCount = $user->getUserGearCount('C');
        $shoesCount = $user->getUserGearCount('S');
        $totalCount = $user->getUserGearCount();
        $gearCount = [$headCount, $clothesCount, $shoesCount, $totalCount];

        
        return view('users.dashboard', [
            'user' => $user,
            'recentGears' => $gears,
            'recentGearsets' => $gearsets,
            'gearCount' =>$gearCount
        ]);
    }
}
