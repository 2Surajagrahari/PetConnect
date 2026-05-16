<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('pets.manage') }}" class="text-stone-400 hover:text-orange-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-stone-900">Add a New Pet</h1>
                <p class="text-sm text-stone-400 mt-0.5">Fill in the details to create a new adoption listing.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Main Details --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
                        <h2 class="font-bold text-stone-800 mb-5 pb-3 border-b border-stone-100">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Pet Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Bella" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Species</label>
                                <select name="species" class="input-field">
                                    <option value="">Select Species</option>
                                    @foreach(['Dog', 'Cat', 'Bird', 'Rabbit', 'Fish', 'Other'] as $sp)
                                    <option value="{{ $sp }}" {{ old('species') === $sp ? 'selected' : '' }}>{{ $sp }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Breed</label>
                                <input type="text" name="breed" value="{{ old('breed') }}" placeholder="e.g. Golden Retriever" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Age (years)</label>
                                <input type="number" name="age" value="{{ old('age') }}" min="0" placeholder="e.g. 2" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Gender</label>
                                <select name="gender" class="input-field">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Unknown" {{ old('gender') === 'Unknown' ? 'selected' : '' }}>Unknown</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Size</label>
                                <select name="size" class="input-field">
                                    <option value="">Select Size</option>
                                    <option value="Small" {{ old('size') === 'Small' ? 'selected' : '' }}>Small</option>
                                    <option value="Medium" {{ old('size') === 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="Large" {{ old('size') === 'Large' ? 'selected' : '' }}>Large</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Color</label>
                                <input type="text" name="color" value="{{ old('color') }}" placeholder="e.g. Golden, Black & White" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Location</label>
                                <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Downtown Shelter" class="input-field">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Description</label>
                            <textarea name="description" rows="4" placeholder="Tell potential adopters about this pet's personality, favourite activities, and what makes them special…" class="input-field resize-none">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
                        <h2 class="font-bold text-stone-800 mb-5 pb-3 border-b border-stone-100">Health Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Vaccination Status</label>
                                <input type="text" name="vaccination_status" value="{{ old('vaccination_status') }}" placeholder="e.g. Up to date, Requires booster" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Health Condition</label>
                                <input type="text" name="health_condition" value="{{ old('health_condition') }}" placeholder="e.g. Healthy, Minor allergies" class="input-field">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
                        <h2 class="font-bold text-stone-800 mb-5 pb-3 border-b border-stone-100">Photos</h2>
                        <label class="block cursor-pointer">
                            <div class="border-2 border-dashed border-stone-200 hover:border-orange-300 rounded-xl p-8 text-center transition-colors">
                                <div class="text-3xl mb-2">📸</div>
                                <p class="text-sm font-medium text-stone-600 mb-1">Upload Photos</p>
                                <p class="text-xs text-stone-400">JPG, PNG up to 2MB each</p>
                            </div>
                            <input type="file" name="images[]" multiple accept="image/*" class="hidden">
                        </label>
                    </div>

                    <div class="bg-orange-50 rounded-2xl border border-orange-100 p-5">
                        <h3 class="text-sm font-bold text-orange-700 mb-2">💡 Tips for a great listing</h3>
                        <ul class="text-xs text-orange-600 space-y-1.5 leading-relaxed">
                            <li>• Use a clear, recent photo</li>
                            <li>• Describe the pet's personality honestly</li>
                            <li>• Mention if they're good with kids or other pets</li>
                            <li>• Note any special needs or requirements</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center py-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Create Listing
                    </button>
                    <a href="{{ route('pets.manage') }}" class="btn-secondary w-full justify-center">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
