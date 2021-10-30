@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center min-h-screen">
        <div class="lg:w-4/12 md:w-8/12 w-11/12 bg-white p-6 rounded-lg shadow-md">

            <div id="forgot-password-header">
                <h1 class="mb-6 text-3xl font-bold text-center">Forgot Password</h1>
            </div>

            @if (session('status'))
                {{-- success message --}}
                <div class="bg-green-500 p-4 rounded-lg mb-6 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif
            
            <form action="{{ route('password.email') }}" method="post">
                @csrf

                <div class="mb-5">
                    <x-label for="email" value="Email" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />

                    @error('email')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <x-button text="Email Reset Link" />
                </div>
            </form>

            <div class="text-center">
                <x-link link="{{ route('login') }}" text="Have an account? Login here" class="text-sm opacity-75" />
            </div>
        </div>
    </div>
@endsection