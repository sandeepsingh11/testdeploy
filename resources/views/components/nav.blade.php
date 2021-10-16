<nav class="bg-primary-500 text-white flex justify-between">
    <ul class="flex items-center">
        <x-nav-link link="{{ route('home') }}" text="SB" />
    </ul>

    <ul class="flex items-center">
        @auth
            <x-nav-link link="{{ route('gears.create', Request::user()) }}" text="+Gear" />
            <x-nav-link link="{{ route('gearsets.create', Request::user()) }}" text="+Gearset" />

            {{-- dropdown container --}}
            <div x-data="{ open: false }" class="relative">
                <button 
                    @click="open = true" 
                    @mouseenter="open = true"
                    class="block p-3 hover:bg-primary-600 focus:hover:bg-primary-600 transition-colors"
                >
                    Profile
                </button>
            
                {{-- dropdown --}}
                <ul
                    x-show.transition="open"
                    @click.away="open = false"
                    @mouseleave="open = false"
                    class="absolute top-full right-0 bg-primary-500 mt-1 rounded text-left z-10"
                    style="display: none"
                >
                    <x-nav-link link="{{ route('dashboard', Request::user()) }}" text="Dashboard" class="py-2 px-4" />
                    <x-nav-link link="{{ route('gears', Request::user()) }}" text="Gears" class="py-2 px-4" />
                    <x-nav-link link="{{ route('gearsets', Request::user()) }}" text="Gearsets" class="py-2 px-4" />
                    {{-- <x-nav-link link="{{ route('settings', Request::user()) }}" text="Settings" class="py-2 px-4" /> --}}
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="w-full py-2 px-4 text-left hover:bg-primary-600 focus:hover:bg-primary-600 transition-colors">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth

        @guest
            <x-nav-link link="{{ route('login') }}" text="Login" />
            <x-nav-link link="{{ route('register') }}" text="Register" />
        @endguest
    </ul>
</nav>