<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found — PetConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50 text-stone-800 antialiased min-h-screen flex flex-col">
    <div class="flex-1 flex items-center justify-center px-4 py-20">
        <div class="text-center max-w-md">
            <div class="text-8xl mb-6">🐾</div>
            <h1 class="text-6xl font-extrabold text-stone-900 mb-2" style="font-family:'Playfair Display',serif">404</h1>
            <p class="text-xl font-semibold text-stone-700 mb-2">Page not found</p>
            <p class="text-stone-400 mb-8 leading-relaxed">
                Looks like this page wandered off like a curious puppy. Let's get you back home!
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="/" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Go Home
                </a>
                <a href="/pets" class="inline-flex items-center gap-2 border border-stone-200 text-stone-600 hover:bg-white font-semibold px-6 py-3 rounded-xl transition-colors">
                    Find a Pet
                </a>
            </div>
        </div>
    </div>
    <footer class="text-center text-sm text-stone-400 py-6 border-t border-stone-100">
        &copy; {{ date('Y') }} PetConnect. Made with ♥ for pets everywhere.
    </footer>
</body>
</html>
