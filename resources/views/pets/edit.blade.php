<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('pets.manage') }}" class="text-stone-400 hover:text-orange-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-stone-900">Edit: {{ $pet->name }}</h1>
                <p class="text-sm text-stone-400 mt-0.5">Update this pet's profile details and status.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('pets.update', $pet) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
                        <h2 class="font-bold text-stone-800 mb-5 pb-3 border-b border-stone-100">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Pet Name *</label>
                                <input type="text" name="name" value="{{ old('name', $pet->name) }}" required class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Species</label>
                                <select name="species" class="input-field">
                                    <option value="">Select Species</option>
                                    @foreach(['Dog', 'Cat', 'Bird', 'Rabbit', 'Fish', 'Other'] as $sp)
                                    <option value="{{ $sp }}" {{ old('species', $pet->species) === $sp ? 'selected' : '' }}>{{ $sp }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Breed</label>
                                <input type="text" name="breed" value="{{ old('breed', $pet->breed) }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Age (years)</label>
                                <input type="number" name="age" value="{{ old('age', $pet->age) }}" min="0" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Gender</label>
                                <select name="gender" class="input-field">
                                    @foreach(['Male', 'Female', 'Unknown'] as $g)
                                    <option value="{{ $g }}" {{ old('gender', $pet->gender) === $g ? 'selected' : '' }}>{{ $g }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Size</label>
                                <select name="size" class="input-field">
                                    @foreach(['Small', 'Medium', 'Large'] as $s)
                                    <option value="{{ $s }}" {{ old('size', $pet->size) === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Color</label>
                                <input type="text" name="color" value="{{ old('color', $pet->color) }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Location</label>
                                <input type="text" name="location" value="{{ old('location', $pet->location) }}" class="input-field">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Description</label>
                            <textarea name="description" rows="4" class="input-field resize-none">{{ old('description', $pet->description) }}</textarea>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
                        <h2 class="font-bold text-stone-800 mb-5 pb-3 border-b border-stone-100">Health & Status</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Vaccination Status</label>
                                <input type="text" name="vaccination_status" value="{{ old('vaccination_status', $pet->vaccination_status) }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Health Condition</label>
                                <input type="text" name="health_condition" value="{{ old('health_condition', $pet->health_condition) }}" class="input-field">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-3">Adoption Status</label>
                                <div class="grid grid-cols-3 gap-3">
                                    @foreach(['available' => 'Available', 'pending' => 'Pending', 'adopted' => 'Adopted'] as $val => $label)
                                    <label class="flex items-center gap-2 p-3 border-2 rounded-xl cursor-pointer transition-all {{ old('status', $pet->status) === $val ? 'border-orange-400 bg-orange-50' : 'border-stone-200 hover:border-stone-300' }}">
                                        <input type="radio" name="status" value="{{ $val }}" {{ old('status', $pet->status) === $val ? 'checked' : '' }} class="text-orange-500 focus:ring-orange-400">
                                        <span class="text-sm font-medium text-stone-700">{{ $label }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    @if($pet->images->count() > 0)
                    <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
                        <h2 class="font-bold text-stone-800 mb-4 pb-3 border-b border-stone-100">Current Photos</h2>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($pet->images as $img)
                            <div class="relative aspect-square rounded-xl overflow-hidden bg-stone-100">
                                <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
                        <h2 class="font-bold text-stone-800 mb-4 pb-3 border-b border-stone-100">Add More Photos</h2>
                        <label class="block cursor-pointer">
                            <div class="border-2 border-dashed border-stone-200 hover:border-orange-300 rounded-xl p-6 text-center transition-colors">
                                <div class="text-2xl mb-1">📸</div>
                                <p class="text-xs text-stone-400">Click to upload new images</p>
                            </div>
                            <input type="file" name="images[]" multiple accept="image/*" class="hidden">
                        </label>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center py-4">Save Changes</button>
                    <a href="{{ route('pets.manage') }}" class="btn-secondary w-full justify-center">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
