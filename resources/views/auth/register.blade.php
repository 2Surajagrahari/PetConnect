<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-stone-900 mb-1" style="font-family:'Playfair Display',serif">Create your account</h2>
        <p class="text-stone-400 text-sm">Join PetConnect and find your perfect companion today.</p>
    </div>

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

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Full Name --}}
        <div>
            <label for="name" class="block text-xs font-bold text-stone-500 uppercase tracking-wide mb-2">Full Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input
                    id="name" type="text" name="name"
                    value="{{ old('name') }}"
                    required autofocus autocomplete="name"
                    minlength="2" maxlength="255"
                    placeholder="Jane Smith"
                    class="input-field pl-11 {{ $errors->has('name') ? 'border-red-400 bg-red-50' : '' }}"
                >
            </div>
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-bold text-stone-500 uppercase tracking-wide mb-2">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input
                    id="email" type="email" name="email"
                    value="{{ old('email') }}"
                    required autocomplete="username"
                    maxlength="255"
                    placeholder="you@example.com"
                    class="input-field pl-11 {{ $errors->has('email') ? 'border-red-400 bg-red-50' : '' }}"
                >
            </div>
        </div>

        {{-- Phone --}}
        <div>
            <label for="phone" class="block text-xs font-bold text-stone-500 uppercase tracking-wide mb-2">Phone Number <span class="text-stone-400 font-normal normal-case">(Optional)</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <input
                    id="phone" type="tel" name="phone"
                    value="{{ old('phone') }}"
                    autocomplete="tel"
                    maxlength="20"
                    pattern="^[0-9\s\-\+\(\)]*$"
                    placeholder="(555) 123-4567"
                    class="input-field pl-11 {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : '' }}"
                >
            </div>
        </div>

        {{-- Address --}}
        <div>
            <label for="address" class="block text-xs font-bold text-stone-500 uppercase tracking-wide mb-2">Address <span class="text-stone-400 font-normal normal-case">(Optional)</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <input
                    id="address" type="text" name="address"
                    value="{{ old('address') }}"
                    autocomplete="street-address"
                    maxlength="500"
                    placeholder="123 Main St, City, Country"
                    class="input-field pl-11 {{ $errors->has('address') ? 'border-red-400 bg-red-50' : '' }}"
                >
            </div>
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-xs font-bold text-stone-500 uppercase tracking-wide mb-2">Password</label>
            <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    required autocomplete="new-password"
                    minlength="8"
                    placeholder="Min. 8 characters (letters, numbers, symbols)"
                    class="input-field pl-11 pr-12 {{ $errors->has('password') ? 'border-red-400 bg-red-50' : '' }}"
                >
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-stone-400 hover:text-stone-600 transition-colors">
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-stone-500 uppercase tracking-wide mb-2">Confirm Password</label>
            <div class="relative" x-data="{ show2: false }">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input
                    id="password_confirmation"
                    :type="show2 ? 'text' : 'password'"
                    name="password_confirmation"
                    required autocomplete="new-password"
                    minlength="8"
                    placeholder="Repeat your password"
                    class="input-field pl-11 pr-12 {{ $errors->has('password_confirmation') ? 'border-red-400 bg-red-50' : '' }}"
                >
                <button type="button" @click="show2 = !show2" class="absolute inset-y-0 right-0 pr-4 flex items-center text-stone-400 hover:text-stone-600 transition-colors">
                    <svg x-show="!show2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show2" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
        </div>

        {{-- Trust note --}}
        <div class="flex items-start gap-2.5 py-3 px-4 bg-orange-50 border border-orange-100 rounded-xl">
            <svg class="w-4 h-4 text-orange-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <p class="text-xs text-stone-500 leading-relaxed">Your information is safe with us. We never share your data with third parties.</p>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full justify-center py-3.5 text-base">
            Create My Account
        </button>

        {{-- Login link --}}
        <p class="text-center text-sm text-stone-500 pt-2">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-orange-500 hover:text-orange-700 transition-colors">Sign in →</a>
        </p>
    </form>
</x-guest-layout>
