@extends('layouts.app')

@section('content')
    
    <h2 class="text-2xl font-bold text-center mb-8">{{ $user->username }}'s gears</h2>

    @if ($gears->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start w-full lg:w-10/12 xl:w-11/12 mx-auto mb-8 px-4 md:px-8">
            @foreach ($gears as $gear)
                {{-- gear component --}}
                <x-gear.base :gear="$gear" :user="$user" />
            @endforeach
        </div>
    @else
        <p class="text-xl text-center italic font-semibold">{{ $user->username }} does not have any gear yet...</p>
    @endif

@endsection