@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-4/12 bg-white my-4 p-6 rounded-lg shadow-md">
            <div id="login-header">
                <h1 class="mb-6 text-3xl font-bold text-center">Login</h1>
            </div>
            
            @if (session('status'))
                {{-- error message --}}
                <div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('reset-pw'))
                {{-- success message --}}
                <div class="bg-green-500 p-4 rounded-lg mb-6 text-white text-center">
                    {{ session('reset-pw') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="post">
                @csrf

                <div class="mb-5">
                    <x-label for="username" value="Username" />
                    <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />

                    @error('username')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-5">
                    <x-label for="password" value="Password" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />

                    @error('password')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-7">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="mr-1 rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            <label for="remember">Remember me</label>
                        </div>

                        <div>
                            <x-link link="{{ route('password.request') }}" text="Forgot password?" />
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <x-button text="Login" />
                </div>
            </form>

            <div class="text-center">
                <x-link link="{{ route('register') }}" text="No account? Register here" class="text-sm opacity-75" />
            </div>
        </div>
    </div>
@endsection