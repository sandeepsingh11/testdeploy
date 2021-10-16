@extends('layouts.app')

@section('content')
    {{-- hero --}}
    <div id="hero-container" class="relative h-screen mb-10">
        {{-- bg img --}}
        <div id="hero-bg-img" class="bg-gray-800 absolute top-0 left-0 w-full">
            <img src="{{ asset('storage/img/splatoon2-cover.jpg') }}" alt="Splatoon 2 cover"
                class="w-full h-screen object-cover object-center opacity-25"
            >
        </div>

        {{-- hero content --}}
        <div id="hero-content-container" class="relative z-10 h-full flex flex-wrap items-center">
            {{-- cta --}}
            <div id="hero-text" class="text-white md:w-6/12 w-full md:p-8 p-4">
                <h1 class="mb-6 md:text-6xl text-4xl font-semibold">Welcome to Splat Build!</h1>
                <p class="md:text-2xl text-xl leading-relaxed mb-5">Start logging your gears with real time stats. Then, assemble your gearsets with the gears you have already built. Be the freshest squid on the block!</p>
                <x-button-link link="{{ route('register') }}" text="Sign up" class="md:text-lg" />
            </div>
            
            {{-- feature img --}}
            <div id="hero-featured-img" class="md:block hidden md:w-6/12 w-full h-3/4 md:p-0 p-2">
                <img src="{{ asset('storage/img/gear-card.png') }}" alt="Gear snippet"
                    class="object-cover object-center rounded h-full mx-auto"
                >
            </div>
        </div>
    </div>
    
    {{-- building --}}
    <div id="building-container" class="md:w-10/12 w-full mx-auto mb-8 p-8">
        <x-header text="Building Gears and Gearsets" />
        
        <p class="mb-2 text-lg">Start by creating gears that you have in-game. Create a title and description for the new gear, like the purpose or strength of using this gear. Select a head, clothing, or shoe gear, then add skills to it. Using Lean's algorithm, you can see the gear stats updating as you add or change skills!</p>
        <img src="{{ asset('storage/img/gear-row.png') }}" alt="Created gears snippet" class="md:w-11/12 w-full rounded mx-auto mb-10">

        <p class="mb-2 text-lg">After you've created a head, clothing, and shoe gear, you can start building your gearset! Gearsets also contain a title and description, along with which ranked modes you plan on using this gearset. Assemble the gearset with existing pieces of gears that you've created already. Finally, pick a weapon that would complement this gearset well. And boom! You have the freshest build on the block.</p>
        <img src="{{ asset('storage/img/gearset.png') }}" alt="Created gearset snippet" class="md:w-11/12 w-full rounded mx-auto mb-5">
    </div>

    {{-- stats --}}
    <div id="stats-container" class="bg-indigo-800 text-white">
        <div id="stats-wrapper" class="md:w-10/12 w-full mx-auto mb-8 px-8 py-12">
            <div class="flex flex-wrap items-center">
                <div class="md:w-2/5 w-full md:mb-0 mb-6">
                    <x-header text="Skill Stats" />
                    <p class="mb-6 text-lg md:w-10/12 w-full">Thanks to Lean's work, we are able to calculate the effectiveness of skills! When building your gears and gearsets, you'll be able to see the skill stat calculations in real-time. This way, you know your builds are the best</p>
                    <x-button-link link="https://github.com/Leanny" text="Lean's GitHub" target="_blank" rel="noopener noreferrer" />
                </div>
                <div class="md:w-3/5 w-full flex flex-wrap justify-center md:mt-0 mt-6 py-8">
                    <img src="{{ asset('storage/img/gear-card.png') }}" alt="Gear snippet" class="w-1/2 rounded transform translate-x-4 -translate-y-4">
                    <img src="{{ asset('storage/img/gear-stats.png') }}" alt="Gear stats" class="w-1/2 rounded transform -translate-x-4 translate-y-4 shadow-lg z-10">
                </div>
            </div>
        </div>
    </div>

    {{-- recent builds --}}
    <div id="recent-builds" class="md:w-10/12 w-full mx-auto mb-8 p-8">
        <x-header text="Recent Builds" />

        {{-- gears --}}
        <div class="mb-8">
            <x-sub-header text="Gears" />
            <div id="recent-gear-container" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                @foreach ($recentGears as $gear)
                    <div>
                        <x-gear.base :gear="$gear" :user="$gear->user" />
                        <i>Gear by {{ $gear->user->username }}</i>
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
                        <x-gearset.base :gearset="$gearset" :user="$gearset->user" />
                        <i>Gearset by {{ $gearset->user->username }}</i>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection