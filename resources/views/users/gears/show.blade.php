@extends('layouts.app')

@section('content')
    @php
        $gearController = new App\Http\Controllers\User\GearController;
        $skills = $gearController->getGearSkills($gear);    
    @endphp

    <x-gear-piece.base :gear="$gear" :skills="$skills" :user="$user" />

    <i>Gear by {{ $user->username }}</i>
@endsection