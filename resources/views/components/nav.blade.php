<nav class="p-2 bg-primary-500 text-white flex justify-between">
    <ul class="flex items-center">
        <li>
            <a href="{{ route('home') }}" class="p-3 pl-0">Splat Build</a>
        </li>
    </ul>

    <ul class="flex items-center">
        <li>
            <a href="{{ route('home') }}" class="p-3">Home</a>
        </li>

        @auth
            <li>
                <a href="{{ route('dashboard', Request::user()) }}" class="p-3">Dashboard</a>
            </li>
            
            <li>
                <form action="{{ route('logout') }}" method="post" class="inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
        @endauth

        @guest
            <li>
                <a href="{{ route('login') }}" class="p-3">Login</a>
            </li>
            <li>
                <a href="{{ route('register') }}" class="p-3">Register</a>
            </li>
        @endguest
    </ul>
</nav>