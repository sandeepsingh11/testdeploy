@extends('layouts.app')

@section('content')
    <h1>Hewwo!</h1>
    <img src="{{ asset('storage/skills/ComeBack.png') }}" alt="">
    <span>{{ Storage::disk('local')->get('splatdata/GearInfo_Head.json') }}</span>
@endsection