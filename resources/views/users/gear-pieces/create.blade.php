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
    <form action="/" method="post">
        @csrf

        {{-- gear name --}}
        <div>
            <label for="gear-piece-name" class="block">Gear name:</label>
            <input type="text" name="gear-piece-name" id="gear-piece-name">
        </div>

        {{-- gear desc --}}
        <div>
            <label for="gear-piece-desc" class="block">Gear description:</label>
            <input type="text" name="gear-piece-desc" id="gear-piece-desc">
        </div>

        {{-- gearpiece --}}
        <div class="w-1/3 mx-auto bg-indigo-500">
            @livewire('game-gp-select', ['gearpieces' => $gearpieces, 'skills' => $skillsData])
        </div>

        <input type="submit" class="p-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 hover:cursor-pointer" value="Create">
    </form>
@endsection

@section('scripts')
    @livewireScripts
@endsection