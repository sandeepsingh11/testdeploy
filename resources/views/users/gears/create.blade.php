@extends('layouts.app')

@section('scripts-head')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection

@section('styles')
    @livewireStyles
@endsection

@section('content')
    @foreach ($errors->all() as $message)
        <h1>{{ $message }}</h1>
    @endforeach

    {{-- form --}}
    <form action="{{ route('gears.store', $user) }}" method="post" class="w-full md:w-1/2 lg:w-1/3 px-4 md:px-0 md:mx-auto">
        @csrf

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-center">Create Gear</h2>
        </div>

        {{-- gear name --}}
        <div class="mb-4">
            <label for="gear-name" class="block">Gear name:</label>
            <input type="text" name="gear-name" id="gear-name" class="w-full rounded focus:ring-primary-400 focus:border-primary-400">
        </div>

        {{-- gear desc --}}
        <div class="mb-4">
            <label for="gear-desc" class="block">Gear description:</label>
            <textarea name="gear-desc" id="gear-desc" cols="30" rows="3" class="w-full rounded focus:ring-primary-400 focus:border-primary-400"></textarea>
        </div>

        {{-- gear and skills selector --}}
        <div class="mb-6">
            <x-gear.gear-skills-builder :gears="$gears" :skills="$skillsData" />
        </div>

        {{-- submit --}}
        <input type="submit" class="p-2 bg-transparent text-primary-700 rounded-md border border-primary-700 mb-2 cursor-pointer transition-colors hover:bg-primary-500 hover:text-white hover:border-primary-500" value="Create">
    </form>
@endsection

@section('scripts')
    @livewireScripts
@endsection