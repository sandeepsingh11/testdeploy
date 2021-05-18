@extends('layouts.app')

@section('content')
    <h1>{{ $user->username }}'s gearsets</h1>

    @if ($gearsets->count())
        <div class="flex justify-evenly flex-wrap">
            @foreach ($gearsets as $gearset)

                <a href="{{ route('gearsets.show', [$user, $gearset]) }}" class="h-full mb-6">
                    {{-- gearset component --}}
                    <x-gearset.base :gearset="$gearset" :gears="$gears" :weapons="$splatdata[4]" :user="$user" />
                </a>
                
            @endforeach
        </div>
    @else
        {{ $user->username }} does not have any gearsets yet...
    @endif
@endsection