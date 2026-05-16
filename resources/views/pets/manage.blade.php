<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-stone-900">Manage Pets</h1>
                <p class="text-sm text-stone-400 mt-1">All pets in the system — edit, update status, or remove listings.</p>
            </div>
            <a href="{{ route('pets.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New Pet
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($pets->count())
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-stone-50 border-b border-stone-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-stone-500 uppercase tracking-wider">Pet</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-stone-500 uppercase tracking-wider">Details</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-stone-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-stone-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-stone-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @php
                    $fallbackImages = [
                        'retriever' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=80&q=80',
                        'beagle' => 'https://images.unsplash.com/photo-1505628346881-b72b27e84530?auto=format&fit=crop&w=80&q=80',
                        'siamese' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=80&q=80',
                        'default' => 'https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=80&q=80',
                    ];
                    @endphp
                    @foreach($pets as $pet)
                    @php
                        $breedLower = strtolower($pet->breed ?? '');
                        $imgFallback = $fallbackImages['default'];
                        foreach ($fallbackImages as $key => $url) {
                            if ($key !== 'default' && str_contains($breedLower, $key)) {
                                $imgFallback = $url;
                                break;
                            }
                        }
                    @endphp
                    <tr class="hover:bg-amber-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-stone-100 flex-shrink-0">
                                    @if($pet->images->count() > 0)
                                        <img src="{{ Storage::url($pet->images->first()->image_path) }}" class="w-full h-full object-cover" alt="{{ $pet->name }}">
                                    @else
                                        <img src="{{ $imgFallback }}" class="w-full h-full object-cover" alt="{{ $pet->name }}">
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-stone-900">{{ $pet->name }}</p>
                                    <p class="text-xs text-stone-400">ID #{{ $pet->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-stone-600">
                            <p>{{ $pet->breed ?? 'Mixed' }}</p>
                            <p class="text-xs text-stone-400">{{ $pet->age }} yrs · {{ $pet->gender }} · {{ $pet->size }}</p>
                        </td>
                        <td class="px-6 py-4 text-stone-500">{{ $pet->location ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($pet->status === 'available') <span class="badge-available">Available</span>
                            @elseif($pet->status === 'pending') <span class="badge-pending">Pending</span>
                            @else <span class="badge-adopted">Adopted</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('pets.show', $pet) }}" class="p-2 text-stone-400 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition-colors" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('pets.edit', $pet) }}" class="p-2 text-stone-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('pets.destroy', $pet) }}" onsubmit="return confirm('Delete {{ $pet->name }}? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-stone-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $pets->links() }}</div>
        @else
        <div class="text-center py-20 bg-white rounded-2xl border border-stone-100">
            <div class="text-5xl mb-4">🐾</div>
            <h3 class="text-lg font-semibold text-stone-800 mb-2">No pets listed yet</h3>
            <p class="text-stone-400 mb-6">Start by adding your first pet to the system.</p>
            <a href="{{ route('pets.create') }}" class="btn-primary">Add Your First Pet</a>
        </div>
        @endif
    </div>
</x-app-layout>
