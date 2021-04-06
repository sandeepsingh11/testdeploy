<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index()
    {
        // get local json files
        $headgear = Storage::disk('local')->get('splatdata/GearInfo_Head.json');
        $headgear = json_decode($headgear, true);
        
        $skills = Storage::disk('local')->get('splatdata/Skills.json');
        $skills = json_decode($skills, true);
        
        

        return view('index', [
            'headgear' => $headgear,
            'skills' => $skills,
        ]);
    }
}
