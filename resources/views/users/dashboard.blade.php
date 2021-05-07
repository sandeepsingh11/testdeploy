@extends('layouts.app')

@section('content')
    <h2 class="mb-6">Hello {{ $user->username }}</h2>
    
    <ul>
        <li>
            <a href="{{ route('gearpieces.create', $user) }}">New Gearpiece</a>
        </li>
        <li>
            <a href="{{ route('gearpieces', $user) }}">All Gearpieces</a>
        </li>

        <li>
            <a href="{{ route('gears.create', $user) }}">New Gear</a>
        </li>
        <li>
            <a href="{{ route('gears', $user) }}">All Gears</a>
        </li>
    </ul>
@endsection