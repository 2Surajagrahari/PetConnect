<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}PetConnect | Pet Adoption & Care</title>
    <meta name="description"
        content="Find your perfect companion. Browse adoptable pets, learn about pet care, and connect with local shelters.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
</head>

<body class="bg-amber-50 text-stone-800 antialiased">

    @include('layouts.navigation')

    {{-- Page Header --}}
    @isset($header)
        <div class="bg-white border-b border-stone-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{ $header }}
            </div>
        </div>
    @endisset

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="fixed top-20 right-4 z-50 max-w-sm w-full bg-white border border-green-200 rounded-2xl shadow-lg shadow-green-100 p-4 flex items-start gap-3">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-stone-800 text-sm">Success!</p>
                <p class="text-stone-500 text-xs mt-0.5">{{ session('success') }}</p>
            </div>
            <button @click="show=false" class="ml-auto text-stone-300 hover:text-stone-500"><svg class="w-4 h-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg></button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,5000)"
            class="fixed top-20 right-4 z-50 max-w-sm w-full bg-white border border-red-200 rounded-2xl shadow-lg shadow-red-100 p-4 flex items-start gap-3">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <p class="text-stone-600 text-sm">{{ session('error') }}</p>
            <button @click="show=false" class="ml-auto text-stone-300 hover:text-stone-500"><svg class="w-4 h-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="fixed top-20 right-4 z-50 max-w-sm w-full bg-white border border-red-200 rounded-2xl shadow-lg p-4"
            x-data="{show:true}" x-show="show">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-stone-800 text-sm mb-1">Please fix these errors:</p>
                    <ul class="text-xs text-red-600 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show=false" class="text-stone-300 hover:text-stone-500"><svg class="w-4 h-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg></button>
            </div>
        </div>
    @endif

    {{-- Pop-up Notifications (Database) --}}
    @auth
        @if(auth()->user()->unreadNotifications->count() > 0)
            <div x-data="{ notifications: {{ auth()->user()->unreadNotifications->toJson() }}, activeIndex: 0, show: true, dismiss() { this.show = false; this.markAsRead(this.notifications[this.activeIndex].id); setTimeout(() => { if (this.activeIndex < this.notifications.length - 1) { this.activeIndex++; this.show = true; } }, 500); }, markAsRead(id) { fetch('/notifications/' + id + '/mark-as-read', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Content-Type': 'application/json' } }); } }" 
                x-show="show && notifications.length > 0" 
                x-init="setTimeout(() => dismiss(), 8000)"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="fixed bottom-6 right-6 z-50 max-w-sm w-full bg-white border border-orange-200 rounded-2xl shadow-xl shadow-orange-100 p-4 flex items-start gap-4">
                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <svg class="w-5 h-5 text-orange-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-stone-900 text-sm mb-0.5" x-text="notifications[activeIndex].data.type_label || 'New Notification'"></p>
                    <p class="text-stone-500 text-sm leading-relaxed" x-text="notifications[activeIndex].data.message"></p>
                    <div class="mt-3 flex gap-2">
                        <button @click="dismiss()" class="text-xs font-semibold text-orange-600 hover:text-orange-700 bg-orange-50 px-3 py-1.5 rounded-lg transition-colors">Acknowledge</button>
                    </div>
                </div>
                <button @click="dismiss()" class="text-stone-400 hover:text-stone-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
        @endif
    @endauth

    <main>{{ $slot }}</main>

    {{-- Footer --}}
    <footer class="bg-stone-900 text-stone-400 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                            </svg>
                        </div>
                        <span class="font-bold text-white text-xl"
                            style="font-family:'Playfair Display',serif">PetConnect</span>
                    </div>
                    <p class="text-stone-400 leading-relaxed max-w-xs">Every pet deserves a loving home. We connect
                        compassionate people with animals who need them most.</p>
                    <div class="flex gap-4 mt-6">
                        <!-- <a href="#"
                            class="w-9 h-9 bg-stone-800 hover:bg-orange-500 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a> -->
                        <!-- <a href="#"
                            class="w-9 h-9 bg-stone-800 hover:bg-orange-500 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a> -->
                    </div>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Adopt</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('pets.index') }}" class="hover:text-orange-400 transition-colors">Find a
                                Pet</a></li>
                        <li><a href="{{ route('articles.index') }}" class="hover:text-orange-400 transition-colors">Pet
                                Care Guides</a></li>
                        @auth
                            <li><a href="{{ route('appointments.create') }}"
                                    class="hover:text-orange-400 transition-colors">Book a Visit</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Contact Us</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-orange-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg> hello@petconnect.com</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-orange-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>1234567890</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-orange-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg> 123 Jalandhar, Punjab, 144001 </li>
                    </ul>
                </div>
            </div>
            <div
                class="border-t border-stone-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <p>&copy; {{ date('Y') }} PetConnect. Made with ♥ for pets everywhere.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>