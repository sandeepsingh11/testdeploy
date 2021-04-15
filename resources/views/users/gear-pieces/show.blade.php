@extends('layouts.app')

@section('content')
    @php
        $gpc = new App\Http\Controllers\User\GearPieceController;
        $skills = $gpc->getGearPieceSkills($gearpiece);    
    @endphp

    <x-gear-piece.base :gearpiece="$gearpiece" :skills="$skills" :user="$user" />

    <i>Gearpiece by {{ $user->username }}</i>
@endsection