@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-4/12 bg-white p-6 rounded-lg">
            <form action="{{ route('password.email') }}" method="post">
                @csrf

                <div class="mb-4">
                    <label for="email" class="sr-only">email</label>
                    <input type="email" name="email" id="email" placeholder="email" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('email') }}" required autofocus>
                    
                    {{-- success message --}}
                    <div class="text-green-500 text-center mt-1">
                        {{ session('status') }}
                    </div>

                    @error('email')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Email Reset Link</button>
                </div>
            </form>
        </div>
    </div>
@endsection