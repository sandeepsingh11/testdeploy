@extends('layouts.app')

@section('content')
    <h2>Hello {{ $user->username }}</h2>
    
    <ul>
        <li>
            <a href="{{ route('gearpieces', $user) }}" class="p-3">All Gearpieces</a>
        </li>
        <li>
            <a href="/" class="p-3">New Gearpiece</a>
        </li>
        <li>
            <a href="/" class="p-3">Edit Gearpiece</a>
        </li>

        <li>
            <a href="/" class="p-3">All Gear</a>
        </li>
        <li>
            <a href="/" class="p-3">New Gear</a>
        </li>
        <li>
            <a href="/" class="p-3">Edit Gear</a>
        </li>
    </ul>
@endsection