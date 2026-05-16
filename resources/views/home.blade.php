<x-app-layout>
{{-- HERO --}}
<div class="relative min-h-[92vh] flex items-center overflow-hidden bg-amber-50">
    {{-- Background image --}}
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=2000&q=80"
             alt="Adorable dog looking up happily"
             class="w-full h-full object-cover object-center opacity-20">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-50 via-amber-50/80 to-transparent"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="max-w-xl">
            <p class="section-label mb-4">🐾 Trusted by 500+ Families</p>
            <h1 class="text-5xl md:text-6xl font-extrabold text-stone-900 leading-tight mb-6">
                Give a Pet<br>
                <span class="text-orange-500">a Second Chance</span><br>
                at Love
            </h1>
            <p class="text-lg text-stone-600 leading-relaxed mb-8 max-w-md">
                Thousands of dogs, cats and other animals are waiting for a family just like yours. Find your new best friend today.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('pets.index') }}" class="btn-primary text-base px-8 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Find a Pet
                </a>
                <a href="{{ route('articles.index') }}" class="btn-secondary text-base px-8 py-4">
                    Pet Care Guides
                </a>
            </div>

            {{-- Trust badges --}}
            <div class="flex flex-wrap gap-6 mt-12">
                <div class="flex items-center gap-2 text-sm text-stone-500">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    All pets health-checked
                </div>
                <div class="flex items-center gap-2 text-sm text-stone-500">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    No adoption fee
                </div>
                <div class="flex items-center gap-2 text-sm text-stone-500">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Ongoing support
                </div>
            </div>
        </div>
    </div>

    {{-- Floating pet card --}}
    <div class="hidden lg:block absolute right-16 top-1/2 -translate-y-1/2 z-10 animate-float">
        <div class="bg-white rounded-3xl shadow-2xl shadow-orange-100 overflow-hidden w-72">
            <img src="https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?auto=format&fit=crop&w=400&q=80"
                 alt="Cute dog available for adoption" class="w-full h-52 object-cover">
            <div class="p-5">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h3 class="font-bold text-stone-900 text-xl" style="font-family:'Playfair Display',serif">Buddy</h3>
                        <p class="text-sm text-stone-400">Golden Retriever · 2 yrs</p>
                    </div>
                    <span class="badge-available">Available</span>
                </div>
                <div class="flex items-center gap-1 text-xs text-stone-400">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Downtown Shelter
                </div>
                <a href="{{ route('pets.index') }}" class="mt-4 block btn-primary text-sm py-2.5 text-center">Meet Buddy →</a>
            </div>
        </div>
    </div>
</div>

{{-- Quick Search --}}
<div class="bg-white border-y border-stone-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('pets.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-1.5">Pet Type / Breed</label>
                <input type="text" name="breed" placeholder="e.g. Labrador, Siamese…" class="input-field">
            </div>
            <div class="w-40">
                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-1.5">Size</label>
                <select name="size" class="input-field">
                    <option value="">Any Size</option>
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                </select>
            </div>
            <div class="flex-1 min-w-[160px]">
                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-1.5">Location</label>
                <input type="text" name="location" placeholder="City or shelter name…" class="input-field">
            </div>
            <button type="submit" class="btn-primary whitespace-nowrap px-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Search Pets
            </button>
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="bg-orange-500 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 gap-8 text-center text-white">
            <div>
                <div class="text-4xl font-extrabold mb-1">{{ $stats['available_pets'] }}+</div>
                <div class="text-orange-100 text-sm font-medium">Pets Available</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold mb-1">{{ $stats['adopted_pets'] }}+</div>
                <div class="text-orange-100 text-sm font-medium">Happy Adoptions</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold mb-1">{{ $stats['total_pets'] }}+</div>
                <div class="text-orange-100 text-sm font-medium">Total Pets Listed</div>
            </div>
        </div>
    </div>
</div>

{{-- Featured Pets --}}
<div class="py-20 bg-amber-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <p class="section-label">🐶 Ready for adoption</p>
                <h2 class="text-4xl font-bold text-stone-900">Meet Our<br>Furry Friends</h2>
            </div>
            <a href="{{ route('pets.index') }}" class="btn-secondary hidden md:inline-flex">View All Pets →</a>
        </div>

        @if($featuredPets->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @php
            $fallbackImages = [
                'dog' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=600&q=80',
                'cat' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80',
                'default' => 'https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=600&q=80',
            ];
            @endphp
            @foreach($featuredPets as $pet)
            @php
                $breedLower = strtolower($pet->breed ?? '');
                if (str_contains($breedLower, 'cat') || str_contains($breedLower, 'siamese') || str_contains($breedLower, 'persian') || str_contains($breedLower, 'maine')) {
                    $fallback = $fallbackImages['cat'];
                } elseif (str_contains($breedLower, 'dog') || str_contains($breedLower, 'retriever') || str_contains($breedLower, 'beagle') || str_contains($breedLower, 'labrador') || str_contains($breedLower, 'poodle') || str_contains($breedLower, 'husky')) {
                    $fallback = $fallbackImages['dog'];
                } else {
                    $fallback = $fallbackImages['default'];
                }
            @endphp
            <div class="card group">
                <div class="relative h-56 overflow-hidden bg-stone-100">
                    @if($pet->images->count() > 0)
                    <img src="{{ Storage::url($pet->images->first()->image_path) }}"
                         alt="{{ $pet->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <img src="{{ $fallback }}"
                         alt="{{ $pet->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif
                    <div class="absolute top-3 right-3">
                        <span class="badge-available">Available</span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="text-xl font-bold text-stone-900" style="font-family:'Playfair Display',serif">{{ $pet->name }}</h3>
                        <span class="text-xs font-semibold {{ $pet->gender === 'Female' ? 'text-pink-500 bg-pink-50' : 'text-blue-500 bg-blue-50' }} px-2 py-0.5 rounded-full">{{ $pet->gender }}</span>
                    </div>
                    <p class="text-sm text-stone-400 mb-1">{{ $pet->breed ?? 'Mixed Breed' }} · {{ $pet->age }} yr{{ $pet->age != 1 ? 's' : '' }} · {{ $pet->size }}</p>
                    <p class="flex items-center gap-1 text-xs text-stone-400 mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $pet->location ?? 'Local Shelter' }}
                    </p>
                    <a href="{{ route('pets.show', $pet) }}" class="block text-center py-2.5 text-sm font-semibold text-orange-600 border border-orange-200 rounded-xl hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all">
                        Meet {{ $pet->name }} →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-2xl border border-stone-100">
            <div class="text-5xl mb-4">🐾</div>
            <p class="text-stone-500">No pets listed yet. Check back soon!</p>
        </div>
        @endif

        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('pets.index') }}" class="btn-secondary">View All Pets</a>
        </div>
    </div>
</div>

{{-- How it Works --}}
<div class="py-20 bg-white border-y border-stone-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="section-label">Simple Process</p>
            <h2 class="text-4xl font-bold text-stone-900">How Adoption Works</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            @foreach([
                ['🔍', 'Browse Pets', 'Search our database of available pets filtered by breed, age, size, and location.'],
                ['💌', 'Apply', 'Submit a short adoption application telling us about your home and lifestyle.'],
                ['📅', 'Book a Visit', 'Schedule a meet-and-greet with your potential new companion.'],
                ['🏠', 'Welcome Home', 'Complete the adoption and bring your new best friend home!'],
            ] as $i => $step)
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-50 border-2 border-orange-100 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">{{ $step[0] }}</div>
                <div class="w-6 h-6 bg-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center mx-auto -mt-10 mb-8 ml-10 relative z-10">{{ $i + 1 }}</div>
                <h3 class="font-bold text-stone-900 mb-2 text-lg" style="font-family:'Playfair Display',serif">{{ $step[1] }}</h3>
                <p class="text-sm text-stone-500 leading-relaxed">{{ $step[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- CTA Banner --}}
<div class="py-20 bg-stone-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=2000&q=80" alt="" class="w-full h-full object-cover">
    </div>
    <div class="relative z-10 max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family:'Playfair Display',serif">
            A pet is waiting for you right now.
        </h2>
        <p class="text-stone-400 mb-8 text-lg">Don't wait. Every day matters for an animal in a shelter.</p>
        <a href="{{ route('pets.index') }}" class="btn-primary text-base px-10 py-4">
            Find My Pet →
        </a>
    </div>
</div>
</x-app-layout>
