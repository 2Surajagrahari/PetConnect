<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('appointments.index') }}" class="text-stone-400 hover:text-orange-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-stone-900">Appointment Details</h1>
                <p class="text-sm text-stone-400 mt-0.5">Booked {{ $appointment->created_at->format('F j, Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Main Info --}}
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                    <h2 class="font-bold text-stone-800 mb-5 pb-3 border-b border-stone-100">Appointment Info</h2>
                    <dl class="space-y-4">
                        <div class="flex items-center gap-4">
                            <dt class="text-xs font-bold text-stone-400 uppercase tracking-wide w-28 flex-shrink-0">Date & Time</dt>
                            <dd class="text-stone-700 text-sm font-semibold">{{ $appointment->date_time->format('l, F j, Y \a\t g:i A') }}</dd>
                        </div>
                        <div class="flex items-center gap-4">
                            <dt class="text-xs font-bold text-stone-400 uppercase tracking-wide w-28 flex-shrink-0">Pet</dt>
                            <dd class="text-stone-700 text-sm">
                                @if($appointment->pet)
                                    <a href="{{ route('pets.show', $appointment->pet) }}" class="text-orange-500 hover:text-orange-700 font-semibold">
                                        {{ $appointment->pet->name }}
                                    </a>
                                    <span class="text-stone-400"> — {{ $appointment->pet->breed ?? 'Mixed' }}</span>
                                @else
                                    <span class="text-stone-400">General Shelter Visit</span>
                                @endif
                            </dd>
                        </div>
                        @can('manage-pets')
                        <div class="flex items-center gap-4">
                            <dt class="text-xs font-bold text-stone-400 uppercase tracking-wide w-28 flex-shrink-0">Visitor</dt>
                            <dd class="text-stone-700 text-sm">{{ $appointment->user->name }} ({{ $appointment->user->email }})</dd>
                        </div>
                        @endcan
                        <div class="flex items-center gap-4">
                            <dt class="text-xs font-bold text-stone-400 uppercase tracking-wide w-28 flex-shrink-0">Status</dt>
                            <dd>
                                @if($appointment->status === 'pending') <span class="badge-pending">Pending</span>
                                @elseif($appointment->status === 'approved') <span class="badge-approved">Confirmed</span>
                                @elseif($appointment->status === 'cancelled') <span class="badge-rejected">Cancelled</span>
                                @else <span class="badge-completed">Completed</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- User: Cancel button --}}
                @if($appointment->status === 'pending' && $appointment->user_id === Auth::id())
                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST"
                      onsubmit="return confirm('Cancel this appointment?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full py-3 text-sm font-semibold text-red-500 border border-red-200 rounded-xl hover:bg-red-50 transition-all">
                        Cancel Appointment
                    </button>
                </form>
                @endif
            </div>

            {{-- Sidebar: Admin status update --}}
            <div class="space-y-6">
                @can('manage-pets')
                <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                    <h2 class="font-bold text-stone-800 mb-4 pb-3 border-b border-stone-100">Update Status</h2>
                    <form action="{{ route('appointments.updateStatus', $appointment) }}" method="POST" class="space-y-3">
                        @csrf @method('PATCH')
                        <select name="status" class="input-field text-sm">
                            @foreach(['pending' => 'Pending', 'approved' => 'Confirmed', 'cancelled' => 'Cancelled', 'completed' => 'Completed'] as $val => $label)
                            <option value="{{ $val }}" {{ $appointment->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-primary w-full justify-center text-sm py-3">Update Status</button>
                    </form>
                </div>
                @endcan

                {{-- Pet card if linked --}}
                @if($appointment->pet)
                <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                    <h2 class="font-bold text-stone-800 mb-4 pb-3 border-b border-stone-100">Pet Profile</h2>
                    <a href="{{ route('pets.show', $appointment->pet) }}" class="block group">
                        <div class="w-full h-32 rounded-xl overflow-hidden bg-stone-100 mb-3">
                            @if($appointment->pet->images->count() > 0)
                                <img src="{{ Storage::url($appointment->pet->images->first()->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl">🐾</div>
                            @endif
                        </div>
                        <h3 class="font-bold text-stone-900 group-hover:text-orange-600 transition-colors">{{ $appointment->pet->name }}</h3>
                        <p class="text-sm text-stone-400">{{ $appointment->pet->breed ?? 'Mixed' }} · {{ $appointment->pet->age }} yrs</p>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
