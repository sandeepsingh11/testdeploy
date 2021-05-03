@extends('layouts.app')

@section('content')
    <h1>{{ $user->username }}'s gears</h1>

    @if ($gears->count())
        <div class="flex justify-evenly flex-wrap">
            @foreach ($gears as $gear)

                <a href="{{ route('gears.show', [$user, $gear]) }}" class="h-full mb-6">
                    {{-- gear component --}}
                    <x-gear.base :gear="$gear" :gearpieces="$gearpieces" :weapons="$splatdata[4]" :user="$user" />
                </a>
                
            @endforeach
        </div>
    @else
        {{ $user->username }} does not have any gears yet...
    @endif
@endsection