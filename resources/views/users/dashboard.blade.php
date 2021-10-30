@extends('layouts.app')

@section('content')
    <div class="min-h-screen">
        <h2 class="mb-6">Hello {{ $user->username }}</h2>
        
        <ul>
            <li>
                <a href="{{ route('gears.create', $user) }}">New Gear</a>
            </li>
            <li>
                <a href="{{ route('gears', $user) }}">All Gears</a>
            </li>
    
            <li>
                <a href="{{ route('gearsets.create', $user) }}">New Gearset</a>
            </li>
            <li>
                <a href="{{ route('gearsets', $user) }}">All Gearsets</a>
            </li>
        </ul>

        {{-- recent builds --}}
    <div id="recent-builds" class="md:w-10/12 w-full mx-auto mb-8 p-8">
        <x-header text="Recent Builds" />

        {{-- gears --}}
        <div class="mb-8">
            <x-sub-header text="Gears" />
            <div id="recent-gear-container" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                @foreach ($recentGears as $gear)
                    <div>
                        <x-gear.base :gear="$gear" :user="$user" />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- gearsets --}}
        <div>
            <x-sub-header text="Gearset" />
            <div id="recent-gearset-container">
                @foreach ($recentGearsets as $gearset)
                    <div>
                        <x-gearset.base :gearset="$gearset" :user="$user" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection