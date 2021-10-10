@extends('layouts.app')

@section('content')
    {{-- hero --}}
    <div id="hero-container" class="relative h-screen">
        {{-- bg img --}}
        <div id="hero-bg-img" class="bg-gray-800 absolute top-0 left-0 w-full">
            <img src="{{ asset('storage/img/splatoon2-cover.jpg') }}" alt="Splatoon 2 cover"
                class="w-full h-screen object-cover object-center opacity-25"
            >
        </div>

        {{-- hero content --}}
        <div id="hero-content-container" class="relative z-10 h-full flex flex-wrap items-center">
            {{-- cta --}}
            <div id="hero-text" class="text-white md:w-6/12 w-full md:p-6 p-4">
                <h1 class="mb-6 md:text-6xl text-4xl font-semibold">Welcome to Splat Build!</h1>
                <p class="md:text-2xl text-xl leading-relaxed mb-5">Start logging your gears with real time stats. Then, assemble your gearsets with the gears you have already built. Be the freshest squid on the block!</p>
                <x-button-link link="{{ route('register') }}" text="Sign up" class="md:text-lg" />
            </div>
            
            {{-- feature img --}}
            <div id="hero-featured-img" class="md:block hidden md:w-6/12 w-full md:p-4 p-2">
                <img src="{{ asset('storage/img/gear-row.png') }}" alt="Gear snippet"
                    class="object-cover object-center rounded"
                >
            </div>
        </div>
    </div>
@endsection