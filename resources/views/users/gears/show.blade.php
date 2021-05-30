@extends('layouts.app')

@section('content')
    @php
        $gearController = new App\Http\Controllers\User\GearController;
        $skills = $gearController->getGearSkills($gear);    
    @endphp

    <div class="w-1/2 mx-auto my-8">
        <x-gear.base :gear="$gear" :skills="$skills" :user="$user" :single=true />
        
        <i>Gear by {{ $user->username }}</i>
    </div>

@endsection