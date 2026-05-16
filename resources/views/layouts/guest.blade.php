<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PetConnect') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="h-full bg-amber-50 antialiased">

<div class="min-h-screen flex">

    {{-- Left Panel — Photo & Branding --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col">
        {{-- Background image --}}
        <img
            src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=1200&q=85"
            alt="Pets"
            class="absolute inset-0 w-full h-full object-cover"
        >
        {{-- Warm overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-orange-600/80 via-amber-700/60 to-stone-900/80"></div>

        {{-- Content over the photo --}}
        <div class="relative z-10 flex flex-col justify-between h-full p-12">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group w-fit">
                <div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                    </svg>
                </div>
                <span class="font-bold text-xl text-white" style="font-family:'Playfair Display',serif">PetConnect</span>
            </a>

            {{-- Headline --}}
            <div>
                <h1 class="text-4xl font-bold text-white leading-tight mb-4" style="font-family:'Playfair Display',serif">
                    Every pet deserves<br>a loving home.
                </h1>
                <p class="text-white/70 text-base leading-relaxed max-w-xs">
                    Join thousands of families who found their perfect companion through PetConnect.
                </p>

                {{-- Testimonial --}}
                <div class="mt-10 bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/20">
                    <p class="text-white/90 text-sm leading-relaxed italic mb-4">
                        "We adopted Luna through PetConnect last year. She's brought so much joy into our home — we can't imagine life without her!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-orange-300 flex items-center justify-center text-orange-900 font-bold text-sm">S</div>
                        <div>
                            <p class="text-white text-sm font-semibold">Sarah M.</p>
                            <p class="text-white/50 text-xs">Adopted Luna, a Siamese cat</p>
                        </div>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="flex gap-8 mt-8">
                    <div>
                        <p class="text-2xl font-bold text-white">500+</p>
                        <p class="text-white/60 text-xs mt-0.5">Happy adoptions</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">50+</p>
                        <p class="text-white/60 text-xs mt-0.5">Partner shelters</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">24/7</p>
                        <p class="text-white/60 text-xs mt-0.5">Support available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Panel — Auth Form --}}
    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 py-12 lg:px-16 xl:px-24 overflow-y-auto">
        {{-- Mobile logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 mb-10 lg:hidden">
            <div class="w-8 h-8 bg-orange-500 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                </svg>
            </div>
            <span class="font-bold text-xl text-stone-900" style="font-family:'Playfair Display',serif">PetConnect</span>
        </a>

        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

</div>

</body>
</html>
