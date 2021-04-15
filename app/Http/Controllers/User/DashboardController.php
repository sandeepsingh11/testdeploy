<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
        
        return view('users.dashboard', [
            'user' => $user
        ]);
    }
}
