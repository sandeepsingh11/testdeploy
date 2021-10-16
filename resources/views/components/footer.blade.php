@php
    $sbLinks = [
        'home' => 'Home',
        'register' => 'Register',
        'login' => 'Login',
    ];

    $ghLinks = [
        'https://github.com/sandeepsingh11/splat-build' => 'Repository',
        'https://github.com/sandeepsingh11/splat-build/pulls' => 'Pull Request',
    ];

    $creditLinks = [
        'https://github.com/Leanny/' => 'Leanny\'s GitHub',
        'https://github.com/sandeepsingh11/' => 'Created by Sandeep',
    ];
@endphp

<footer class="bg-indigo-800 text-gray-300 pt-6 pb-2 px-2">
    <div class="grid grid-cols-1 md:grid-cols-3 justify-evenly mb-3 text-center">
        <div class="mb-4">
            @foreach ($sbLinks as $routeName => $text)
                <div>
                    <a href="{{ route($routeName) }}">{{ $text }}</a>
                </div>    
            @endforeach
        </div>

        <div class="mb-4">
            @foreach ($ghLinks as $routeName => $text)
                <div>
                    <a href="{{ $routeName }}">{{ $text }}</a>
                </div>    
            @endforeach
        </div>

        <div class="mb-4">
            @foreach ($creditLinks as $routeName => $text)
                <div>
                    <a href="{{ $routeName }}">{{ $text }}</a>
                </div>    
            @endforeach
        </div>
    </div>

    <p class="text-gray-400 text-center">This website is not affiliated with Nintendo. All product names, logos, and brands are property of their respective owners.</p>
</footer>