<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-stone-900 mb-1" style="font-family:'Playfair Display',serif">Welcome back</h2>
        <p class="text-stone-400 text-sm">Sign in to your PetConnect account to continue.</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 font-medium">
        {{ session('status') }}
    </div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600">
        <ul class="space-y-1">
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-bold text-stone-500 uppercase tracking-wide mb-2">Email Address</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-orange-500 text-stone-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input
                    id="email" type="email" name="email"
                    value="{{ old('email') }}"
                    required autofocus autocomplete="username"
                    maxlength="255"
                    placeholder="you@example.com"
                    class="w-full pl-11 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-400/10 transition-all outline-none {{ $errors->has('email') ? 'border-red-400 bg-red-50' : '' }}"
                >
            </div>
        </div>

        {{-- Password --}}
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-xs font-bold text-stone-500 uppercase tracking-wide">Password</label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-orange-500 hover:text-orange-700 transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-px after:bg-orange-500 after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:origin-left">
                    Forgot password?
                </a>
                @endif
            </div>
            <div class="relative group" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-orange-500 text-stone-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    required autocomplete="current-password"
                    minlength="8"
                    placeholder="••••••••"
                    class="w-full pl-11 pr-12 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-400/10 transition-all outline-none {{ $errors->has('password') ? 'border-red-400 bg-red-50' : '' }}"
                >
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-stone-400 hover:text-stone-600 transition-colors">
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center gap-2.5">
            <input
                id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 rounded border-stone-300 text-orange-500 focus:ring-orange-400 cursor-pointer"
            >
            <label for="remember_me" class="text-sm text-stone-600 cursor-pointer select-none">Keep me signed in</label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="w-full relative group overflow-hidden rounded-xl bg-orange-500 px-6 py-4 text-white shadow-lg shadow-orange-500/30 transition-all hover:shadow-orange-500/50 hover:bg-orange-600 mt-4">
            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
            <span class="relative text-base font-bold tracking-wide flex items-center justify-center gap-2">
                Sign In to PetConnect
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </span>
        </button>

        {{-- Register link --}}
        <div class="text-center mt-6">
            <p class="text-sm text-stone-500">
                New to PetConnect?
                <a href="{{ route('register') }}" class="font-bold text-orange-500 hover:text-orange-600 transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-px after:bg-orange-500 after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:origin-left">Create a free account</a>
            </p>
        </div>
    </form>
</x-guest-layout>
