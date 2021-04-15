@extends('layouts.app')

@section('content')
    
    <h1>{{ $user->username }}'s gear-pieces</h1>

    @if ($gearpieces->count())
        @foreach ($gearpieces as $gearpiece)

            {{-- get this gearpiece's skills --}}
            @php
                $gpc = new App\Http\Controllers\User\GearPieceController;
                $skills = $gpc->getGearPieceSkills($gearpiece);
            @endphp


            {{-- gearpiece component --}}
            <x-gear-piece.base :gearpiece="$gearpiece" :skills="$skills" :user="$user" />
            
        @endforeach
    @else
        {{ $user }} does not have any gear pieces yet...
    @endif

@endsection