@extends('layouts.app')

@section('content')
    <div class="w-1/2 mx-auto my-8">
        <x-gear.base :gear="$gear" :skills="$skills" :baseGear="$baseGear" :user="$user" :single=true />
        
        <i>Gear by {{ $user->username }}</i>
    </div>

@endsection