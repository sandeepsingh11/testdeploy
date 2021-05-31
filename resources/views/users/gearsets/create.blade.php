@extends('layouts.app')

@section('scripts-head')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection

@section('styles')
    @livewireStyles
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- form --}}
    <form action="{{ route('gearsets.store', $user) }}" method="post" class="w-full md:w-3/4 lg:w-2/3 px-4 md:px-0 md:mx-auto">
        @csrf

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-center">Create Gearset</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 mb-4">
            {{-- gearset name --}}
            <div class="mb-4">
                <label for="gearset-name" class="block">Gearset name:</label>
                <input type="text" name="gearset-name" id="gearset-name"  class="w-full rounded focus:ring-primary-400 focus:border-primary-400">
            </div>
    
            {{-- gearset desc --}}
            <div class="row-start-2 mb-4 md:mb-0">
                <label for="gearset-desc" class="block">Gearset description:</label>
                <textarea name="gearset-desc" id="gearset-desc" class="w-full rounded focus:ring-primary-400 focus:border-primary-400"></textarea>
            </div>
    
            {{-- gearset mode --}}
            <div class="row-span-2">
                <label for="mode" class="block">Game mode:</label>
    
                <div>
                    <input type="checkbox" name="gearset-mode-rm" value="1" class="rounded-sm text-secondary-700 focus:ring-primary-400">
                    <label for="gearset-mode-rm">Rainmaker</label>
                </div>
    
                <div>
                    <input type="checkbox" name="gearset-mode-cb" value="1" class="rounded-sm text-secondary-700 focus:ring-primary-400">
                    <label for="gearset-mode-cb">Clam Blitz</label>
                </div>
    
                <div>
                    <input type="checkbox" name="gearset-mode-sz" value="1" class="rounded-sm text-secondary-700 focus:ring-primary-400">
                    <label for="gearset-mode-sz">Splat Zones</label>
                </div>
    
                <div>
                    <input type="checkbox" name="gearset-mode-tc" value="1" class="rounded-sm text-secondary-700 focus:ring-primary-400">
                    <label for="gearset-mode-tc">Tower Control</label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            {{-- weapons --}}
            <livewire:weapon :weapons="$splatdata[4]" />
    
            {{-- gear (head) --}}
            <livewire:gear :gears="$gears" gearType="head" :skills="$splatdata[3]" />
    
            {{-- gear (clothes) --}}
            <livewire:gear :gears="$gears" gearType="clothes" :skills="$splatdata[3]" />
            
            {{-- gear (shoes) --}}
            <livewire:gear :gears="$gears" gearType="shoes" :skills="$splatdata[3]" />
        </div>



        <input type="submit" value="Create" class="p-2 bg-transparent text-primary-700 rounded-md border border-primary-700 mb-2 cursor-pointer transition-colors hover:bg-primary-500 hover:text-white hover:border-primary-500">
    </form>
@endsection

@section('scripts')
    @livewireScripts
@endsection