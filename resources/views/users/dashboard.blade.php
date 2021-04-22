@extends('layouts.app')

@section('content')
    <h2 class="mb-6">Hello {{ $user->username }}</h2>
    
    <ul>
        <li>
            <a href="{{ route('gearpieces', $user) }}">All Gearpieces</a>
        </li>
        <li>
            <a href="/">New Gearpiece</a>
        </li>
        <li>
            <a href="/">Edit Gearpiece</a>
        </li>

        <li>
            <a href="/">All Gear</a>
        </li>
        <li>
            <a href="{{ route('gears.create', $user) }}">New Gear</a>
        </li>
        <li>
            <a href="/">Edit Gear</a>
        </li>
    </ul>
@endsection