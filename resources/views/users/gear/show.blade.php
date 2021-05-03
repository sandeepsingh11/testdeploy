@extends('layouts.app')

@section('content')
    <div class="w-max mx-auto">
        {{-- gear component --}}
        <x-gear.base :gear="$gear" :gearpieces="$gearpieces" :weapons="$weapons" :user="$user" />
    
        <div class="flex justify-between mt-4">
            <a href="{{ route('gears', $user) }}">{{ $user->username }}'s gears</a>

            <i>Gear by {{ $user->username }}</i>
        </div>
    </div>
@endsection