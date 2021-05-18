@extends('layouts.app')

@section('content')
    <h2 class="mb-6">Hello {{ $user->username }}</h2>
    
    <ul>
        <li>
            <a href="{{ route('gears.create', $user) }}">New Gear</a>
        </li>
        <li>
            <a href="{{ route('gears', $user) }}">All Gears</a>
        </li>

        <li>
            <a href="{{ route('gearsets.create', $user) }}">New Gearset</a>
        </li>
        <li>
            <a href="{{ route('gearsets', $user) }}">All Gearsets</a>
        </li>
    </ul>
@endsection