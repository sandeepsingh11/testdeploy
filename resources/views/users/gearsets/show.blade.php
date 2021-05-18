@extends('layouts.app')

@section('content')
    <div class="w-max mx-auto">
        {{-- gearset component --}}
        <x-gearset.base :gearset="$gearset" :gears="$gears" :weapons="$weapons" :user="$user" />
    
        <div class="flex justify-between mt-4">
            <i>Gearset by {{ $user->username }}</i>
        </div>
    </div>
@endsection