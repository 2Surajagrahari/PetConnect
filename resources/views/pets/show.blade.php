<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-6">
            <a href="{{ route('pets.index') }}" class="inline-flex items-center gap-2 text-sm text-stone-400 hover:text-orange-500 transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to all pets
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-stone-100 shadow-sm overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                {{-- Images --}}
                <div class="w-full lg:w-1/2" x-data="{ active: 0 }">
                    @php
                    $speciesFallbacks = [
                        'bird' => 'https://images.unsplash.com/photo-1552728089-571ebd6a45cb?auto=format&fit=crop&w=800&q=80',
                        'rabbit' => 'https://images.unsplash.com/photo-1585110396000-c9faf4e4f9ba?auto=format&fit=crop&w=800&q=80',
                        'fish' => 'https://images.unsplash.com/photo-1522069169874-c58ec4b76be5?auto=format&fit=crop&w=800&q=80',
                        'other' => 'https://images.unsplash.com/photo-1425082661705-1834bfd0739c?auto=format&fit=crop&w=800&q=80',
                        'dog' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=800&q=80',
                        'cat' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=800&q=80',
                    ];
                    
                    $s = strtolower($pet->species ?? '');
                    $b = strtolower($pet->breed ?? '');
                    
                    $fallback = 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=800&q=80';
                    
                    if (isset($speciesFallbacks[$s])) {
                        $fallback = $speciesFallbacks[$s];
                    }
                    if (str_contains($b, 'cat') || str_contains($b, 'siamese')) {
                        $fallback = $speciesFallbacks['cat'];
                    }
                    @endphp
                    <div class="relative h-80 lg:h-full min-h-[380px] bg-stone-100">
                        @if($pet->images->count() > 0)
                            @foreach($pet->images as $i => $img)
                            <img src="{{ Storage::url($img->image_path) }}" alt="{{ $pet->name }}"
                                 x-show="active === {{ $i }}" x-transition.opacity.duration.400ms
                                 class="absolute inset-0 w-full h-full object-cover">
                            @endforeach
                        @else
                            <img src="{{ $fallback }}" alt="{{ $pet->name }}" class="absolute inset-0 w-full h-full object-cover">
                        @endif

                        {{-- Status overlay --}}
                        <div class="absolute top-4 left-4">
                            @if($pet->status === 'available') <span class="badge-available shadow-sm">Available</span>
                            @elseif($pet->status === 'pending') <span class="badge-pending shadow-sm">Pending</span>
                            @else <span class="badge-adopted shadow-sm">Adopted</span>
                            @endif
                        </div>

                        {{-- Thumb nav --}}
                        @if($pet->images->count() > 1)
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2">
                            @foreach($pet->images as $i => $img)
                            <button @click="active = {{ $i }}"
                                    class="w-14 h-14 rounded-xl overflow-hidden border-2 transition-all"
                                    :class="active === {{ $i }} ? 'border-orange-400 scale-110 shadow-md' : 'border-white/60 opacity-70 hover:opacity-100'">
                                <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">
                            </button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Details --}}
                <div class="w-full lg:w-1/2 p-8 lg:p-10 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h1 class="text-4xl font-bold text-stone-900 leading-tight" style="font-family:'Playfair Display',serif">{{ $pet->name }}</h1>
                            <p class="text-orange-500 font-semibold mt-0.5">{{ $pet->breed ?? 'Mixed Breed' }}</p>
                        </div>
                        <span class="text-sm font-semibold px-3 py-1 rounded-full {{ $pet->gender === 'Female' ? 'bg-pink-50 text-pink-500' : 'bg-blue-50 text-blue-500' }}">{{ $pet->gender }}</span>
                    </div>
                    <p class="flex items-center gap-1.5 text-sm text-stone-400 mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $pet->location ?? 'Local Shelter' }}
                        <span class="text-stone-300 mx-1">·</span>
                        Listed by {{ $pet->user->name }}
                    </p>

                    {{-- Stat pills --}}
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        @foreach([['Age', $pet->age . ' yr' . ($pet->age != 1 ? 's' : '')], ['Size', $pet->size ?? '—'], ['Color', $pet->color ?? '—']] as [$label, $value])
                        <div class="bg-amber-50 rounded-xl p-3 text-center border border-amber-100">
                            <p class="text-xs font-bold text-stone-400 uppercase tracking-wide mb-0.5">{{ $label }}</p>
                            <p class="font-semibold text-stone-800 text-sm">{{ $value }}</p>
                        </div>
                        @endforeach
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <h2 class="font-bold text-stone-800 mb-2">About {{ $pet->name }}</h2>
                        <p class="text-stone-500 text-sm leading-relaxed">{{ $pet->description ?? 'No description available.' }}</p>
                    </div>

                    {{-- Health --}}
                    <div class="bg-stone-50 rounded-xl p-4 mb-6 space-y-2.5 border border-stone-100">
                        @foreach([['Vaccination', $pet->vaccination_status ?? 'Unknown'], ['Health', $pet->health_condition ?? 'Unknown']] as [$label, $value])
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-xs font-bold text-stone-400 uppercase w-28">{{ $label }}</span>
                            <span class="text-sm text-stone-600">{{ $value }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- CTA --}}
                    <div class="mt-auto" x-data="{ showForm: false }">
                        @if($pet->status === 'available')
                        @auth
                        <div class="flex gap-3">
                            <button @click="showForm = true" class="btn-primary flex-1 py-3.5">Apply to Adopt</button>
                            <a href="{{ route('appointments.create', ['pet_id' => $pet->id]) }}" class="btn-secondary flex-1 py-3.5 text-center">Book a Visit</a>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="btn-primary w-full justify-center py-3.5">Sign in to Apply</a>
                        @endauth
                        @else
                        <div class="bg-stone-100 rounded-xl p-4 text-center text-stone-400 font-medium text-sm">This pet is no longer available for adoption.</div>
                        @endif

                        {{-- Adoption Modal --}}
                        <div x-show="showForm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
                            <div x-transition.opacity @click="showForm=false" class="absolute inset-0 bg-stone-900/50 backdrop-blur-sm"></div>
                            <div x-transition.scale.95 class="relative z-10 bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                                <div class="p-8">
                                    <div class="flex justify-between items-center mb-6">
                                        <h2 class="text-2xl font-bold text-stone-900" style="font-family:'Playfair Display',serif">Adopt {{ $pet->name }}</h2>
                                        <button @click="showForm=false" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-stone-100 text-stone-400 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                    <form action="{{ route('applications.store', $pet) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-1.5">Full Name *</label>
                                                <input type="text" name="applicant_name" value="{{ Auth::user()?->name }}" required class="input-field">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-1.5">Phone / Email *</label>
                                                <input type="text" name="contact_details" value="{{ Auth::user()?->email }}" required class="input-field">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-1.5">Home Address *</label>
                                            <textarea name="address" rows="2" required class="input-field resize-none"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-1.5">Occupation</label>
                                            <input type="text" name="occupation" class="input-field">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-1.5">Why do you want to adopt {{ $pet->name }}? *</label>
                                            <textarea name="reason" rows="3" required class="input-field resize-none"></textarea>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-1.5">Living Environment *</label>
                                                <textarea name="living_environment" rows="2" placeholder="House/Apartment, yard, etc." required class="input-field resize-none"></textarea>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-stone-400 uppercase tracking-wide mb-1.5">Previous Pet Experience</label>
                                                <textarea name="previous_experience" rows="2" class="input-field resize-none"></textarea>
                                            </div>
                                        </div>
                                        <div class="flex gap-3 pt-2">
                                            <button type="submit" class="btn-primary flex-1 py-3.5">Submit Application</button>
                                            <button type="button" @click="showForm=false" class="btn-secondary py-3.5 px-6">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
