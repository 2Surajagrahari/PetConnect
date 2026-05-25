<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 10"
     :class="scrolled ? 'bg-white shadow-md shadow-stone-100' : 'bg-amber-50 border-b border-stone-100'"
     class="sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center group-hover:bg-orange-600 transition-colors">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                </div>
                <span class="font-bold text-xl text-stone-800 group-hover:text-orange-600 transition-colors" style="font-family:'Playfair Display',serif">PetConnect</span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('home') ? 'text-orange-600 bg-orange-50' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-100' }}">Home</a>
                <a href="{{ route('pets.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pets.*') ? 'text-orange-600 bg-orange-50' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-100' }}">Find a Pet</a>
                <a href="{{ route('articles.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('articles.*') ? 'text-orange-600 bg-orange-50' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-100' }}">Care Guides</a>
                @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-orange-600 bg-orange-50' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-100' }}">Dashboard</a>
                @endauth
            </div>

            {{-- Auth Buttons --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-stone-100 transition-colors text-sm font-medium text-stone-700">
                        <div class="w-7 h-7 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        {{ Auth::user()->name }}
                        <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak x-transition
                         class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-stone-100 py-2 z-50">
                        <div class="px-4 py-2 border-b border-stone-100 mb-1">
                            <p class="text-xs text-stone-400">Signed in as</p>
                            <p class="text-sm font-semibold text-stone-700 truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-block mt-1 text-xs font-bold px-2 py-0.5 rounded-full {{ Auth::user()->role === 'admin' ? 'bg-red-100 text-red-600' : (Auth::user()->role === 'shelter' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600') }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-stone-600 hover:bg-amber-50 hover:text-orange-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            My Profile
                        </a>
                        @can('manage-pets')
                        <a href="{{ route('pets.manage') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-stone-600 hover:bg-amber-50 hover:text-orange-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Manage Pets
                        </a>
                        <a href="{{ route('appointments.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-stone-600 hover:bg-amber-50 hover:text-orange-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Appointments
                        </a>
                        @endcan
                        <div class="border-t border-stone-100 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-stone-600 hover:text-orange-600 transition-colors">Sign In</a>
                <a href="{{ route('register') }}" class="btn-primary text-sm py-2.5 px-5">Get Started</a>
                @endauth
            </div>

            {{-- Mobile Hamburger --}}
            <button @click="open = !open" class="md:hidden p-2 rounded-lg text-stone-600 hover:bg-stone-100 transition-colors">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-cloak x-transition class="md:hidden bg-white border-t border-stone-100 py-4 px-4">
        <div class="space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm font-medium text-stone-700 hover:bg-amber-50 hover:text-orange-600 rounded-lg">Home</a>
            <a href="{{ route('pets.index') }}" class="block px-4 py-2 text-sm font-medium text-stone-700 hover:bg-amber-50 hover:text-orange-600 rounded-lg">Find a Pet</a>
            <a href="{{ route('articles.index') }}" class="block px-4 py-2 text-sm font-medium text-stone-700 hover:bg-amber-50 hover:text-orange-600 rounded-lg">Care Guides</a>
            @auth
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm font-medium text-stone-700 hover:bg-amber-50 hover:text-orange-600 rounded-lg">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm font-medium text-stone-700 hover:bg-amber-50 hover:text-orange-600 rounded-lg">Profile</a>
            @can('manage-pets')
            <a href="{{ route('pets.manage') }}" class="block px-4 py-2 text-sm font-medium text-stone-700 hover:bg-amber-50 hover:text-orange-600 rounded-lg">Manage Pets</a>
            <a href="{{ route('appointments.index') }}" class="block px-4 py-2 text-sm font-medium text-stone-700 hover:bg-amber-50 hover:text-orange-600 rounded-lg">Appointments</a>
            @endcan
            <div class="pt-2 border-t border-stone-100">
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm font-medium text-red-500 hover:bg-red-50 rounded-lg">Sign Out</button>
                </form>
            </div>
            @else
            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm font-medium text-stone-700 hover:bg-amber-50 rounded-lg">Sign In</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg text-center mt-2">Get Started</a>
            @endauth
        </div>
    </div>
</nav>
