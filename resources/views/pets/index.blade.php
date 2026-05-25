<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-stone-900">Find Your Perfect Companion</h1>
        <p class="text-sm text-stone-400 mt-1">
            {{ $pets->total() }} {{ $pets->total() === 1 ? 'pet' : 'pets' }}
            {{ request()->hasAny(['species','breed','gender','size','location']) ? 'match your filters' : 'available for adoption' }}
        </p>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Sidebar Filters --}}
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 sticky top-24">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="font-bold text-stone-800">Filters</h2>
                        @if(request()->hasAny(['species','breed','gender','size','location']))
                        <a href="{{ route('pets.index') }}" class="text-xs text-orange-500 hover:text-orange-700 font-semibold">Clear all</a>
                        @endif
                    </div>
                    <form action="{{ route('pets.index') }}" method="GET" class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-2">Species</label>
                            <div class="grid grid-cols-3 gap-1.5">
                                @foreach(['Dog' => '🐶', 'Cat' => '🐱', 'Bird' => '🐦', 'Rabbit' => '🐰', 'Fish' => '🐟', 'Other' => '🐾'] as $sp => $emoji)
                                <label class="text-center cursor-pointer">
                                    <input type="radio" name="species" value="{{ $sp }}" {{ request('species') === $sp ? 'checked' : '' }} class="sr-only peer" onchange="this.form.submit()">
                                    <div class="py-1.5 text-xs font-semibold border rounded-lg transition-all peer-checked:border-orange-400 peer-checked:bg-orange-50 peer-checked:text-orange-600 border-stone-200 text-stone-500 hover:border-stone-300 text-center">
                                        <span class="block text-base">{{ $emoji }}</span>{{ $sp }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-2">Breed or Type</label>
                            <input type="text" name="breed" value="{{ request('breed') }}" placeholder="e.g. Beagle, Tabby…" class="input-field">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-2">Gender</label>
                            <div class="space-y-2">
                                @foreach(['Male', 'Female'] as $g)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="gender" value="{{ $g }}" {{ request('gender') === $g ? 'checked' : '' }} class="text-orange-500 focus:ring-orange-400" onchange="this.form.submit()">
                                    <span class="text-sm text-stone-600">{{ $g }}</span>
                                </label>
                                @endforeach
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="gender" value="" {{ !request('gender') ? 'checked' : '' }} class="text-orange-500 focus:ring-orange-400" onchange="this.form.submit()">
                                    <span class="text-sm text-stone-600">Any</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-2">Size</label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach(['Small', 'Medium', 'Large'] as $s)
                                <label class="text-center cursor-pointer">
                                    <input type="radio" name="size" value="{{ $s }}" {{ request('size') === $s ? 'checked' : '' }} class="sr-only peer" onchange="this.form.submit()">
                                    <div class="px-2 py-2 text-xs font-semibold border rounded-lg transition-all peer-checked:border-orange-400 peer-checked:bg-orange-50 peer-checked:text-orange-600 border-stone-200 text-stone-500 hover:border-stone-300">{{ $s }}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-2">Location</label>
                            <input type="text" name="location" value="{{ request('location') }}" placeholder="City or shelter…" class="input-field">
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center text-sm">Apply Filters</button>
                    </form>
                </div>
            </aside>

            {{-- Pet Grid --}}
            <div class="flex-1">
                @can('manage-pets')
                <div class="mb-6 flex justify-end">
                    <a href="{{ route('pets.create') }}" class="btn-primary text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add New Pet
                    </a>
                </div>
                @endcan

                @if($pets->count())
                @php
                $speciesFallbacks = [
                    'bird' => 'https://images.unsplash.com/photo-1552728089-571ebd6a45cb?auto=format&fit=crop&w=600&q=80',
                    'rabbit' => 'https://images.unsplash.com/photo-1585110396000-c9faf4e4f9ba?auto=format&fit=crop&w=600&q=80',
                    'fish' => 'https://images.unsplash.com/photo-1522069169874-c58ec4b76be5?auto=format&fit=crop&w=600&q=80',
                    'other' => 'https://images.unsplash.com/photo-1425082661705-1834bfd0739c?auto=format&fit=crop&w=600&q=80',
                    'dog' => 'https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?auto=format&fit=crop&w=600&q=80',
                    'cat' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80',
                ];
                $breedFallbacks = [
                    'retriever' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=600&q=80',
                    'beagle' => 'https://images.unsplash.com/photo-1505628346881-b72b27e84530?auto=format&fit=crop&w=600&q=80',
                    'labrador' => 'https://images.unsplash.com/photo-1561037404-61cd46aa615b?auto=format&fit=crop&w=600&q=80',
                    'siamese' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80',
                ];
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($pets as $pet)
                    @php
                        $b = strtolower($pet->breed ?? '');
                        $s = strtolower($pet->species ?? '');
                        $img = 'https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=600&q=80'; // default
                        
                        if (isset($speciesFallbacks[$s])) {
                            $img = $speciesFallbacks[$s];
                        }
                        foreach($breedFallbacks as $k => $u) {
                            if (str_contains($b, $k)) { $img = $u; break; }
                        }
                    @endphp
                    <div class="card group">
                        <div class="relative h-52 overflow-hidden bg-stone-100">
                            @if($pet->images->count() > 0)
                                <img src="{{ Storage::url($pet->images->first()->image_path) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <img src="{{ $img }}" alt="{{ $pet->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                            <div class="absolute top-3 right-3">
                                <span class="badge-available">Available</span>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-xl font-bold text-stone-900" style="font-family:'Playfair Display',serif">{{ $pet->name }}</h3>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $pet->gender === 'Female' ? 'bg-pink-50 text-pink-500' : 'bg-blue-50 text-blue-500' }}">{{ $pet->gender }}</span>
                            </div>
                            <p class="text-sm text-stone-400 mb-1">{{ $pet->breed ?? 'Mixed Breed' }} · {{ $pet->age }} yr{{ $pet->age != 1 ? 's' : '' }}</p>
                            <p class="text-xs text-stone-400 flex items-center gap-1 mb-4">
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
                <div class="mt-10">{{ $pets->links() }}</div>
                @else
                <div class="text-center py-20 bg-white rounded-2xl border border-stone-100">
                    <div class="text-5xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-stone-800 mb-2">No pets match your filters</h3>
                    <p class="text-stone-400 mb-6">Try widening your search criteria.</p>
                    <a href="{{ route('pets.index') }}" class="btn-primary">Show All Pets</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
