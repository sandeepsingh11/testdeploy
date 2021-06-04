@extends('layouts.app')

@section('content')
    <div class="w-full lg:w-10/12 mx-auto mb-8 px-4 md:px-8">
        {{-- gearset component --}}
        <x-gearset.base :gearset="$gearset" :gears="$gears" :weapons="$weapons" :user="$user" :single=true />
    
        <div class="grid grid-cols-2 mt-4">
            <i>Gearset by {{ $user->username }}</i>
        </div>
    </div>
@endsection