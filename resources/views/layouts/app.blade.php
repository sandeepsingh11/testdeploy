<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <nav>
        @auth
            <form action="{{ route('logout') }}" method="post" class="p-3 inline">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endauth
    </nav>

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>