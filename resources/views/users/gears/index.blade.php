@extends('layouts.app')

@section('content')
    
    <h1>{{ $user->username }}'s gears</h1>

    @if ($gears->count())
        <div class="flex justify-evenly flex-wrap">
            @foreach ($gears as $gear)
    
                {{-- get this gear's skills --}}
                @php
                    $gearController = new App\Http\Controllers\User\GearController;
                    $skills = $gearController->getGearSkills($gear);
                @endphp
    
    
                {{-- gear component --}}
                <x-gear.base :gear="$gear" :skills="$skills" :user="$user" />
                
            @endforeach
        </div>
    @else
        {{ $user->username }} does not have any gear yet...
    @endif

@endsection