@extends('layouts.app')

@section('content')
    <div class="min-h-screen">
        <h2 class="mt-10 mb-6 text-4xl font-semibold text-center">Welcome {{ $user->username }}</h2>

        {{-- recent builds --}}
        <div id="recent-builds" class="md:w-10/12 w-full mx-auto mb-8 p-8">
            <x-header text="Recent Builds" />
    
            {{-- gears --}}
            <div class="mb-8">
                <x-sub-header text="Gears" />
                <div id="recent-gear-container" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start mb-6">
                    @if ($recentGears->count())
                        @foreach ($recentGears as $gear)
                            <div>
                                <x-gear.base :gear="$gear" :user="$user" />
                            </div>
                        @endforeach
                    @else
                        <p class="text-xl text-center italic py-8">You don't have any gears yet...Go create some fresh gears!</p>
                    @endif
                </div>
                <x-button-link link="{{ route('gears.create', $user) }}" text="Create Gear" />
            </div>
    
            {{-- gearsets --}}
            <div>
                <x-sub-header text="Gearsets" />
                <div id="recent-gearset-container" class="mb-6">
                    @if ($recentGearsets->count())
                        @foreach ($recentGearsets as $gearset)
                            <div>
                                <x-gearset.base :gearset="$gearset" :user="$user" />
                            </div>
                        @endforeach
                    @else
                        <p class="text-xl text-center italic py-8">You don't have any gearsets yet...Go create some fresh gearsets!</p>
                    @endif
                </div>
                <x-button-link link="{{ route('gearsets.create', $user) }}" text="Create Gearset" />
            </div>
        </div>
    </div>
@endsection