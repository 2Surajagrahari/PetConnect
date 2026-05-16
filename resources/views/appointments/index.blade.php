<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-stone-900">
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'shelter')
                        All Appointments
                    @else
                        My Appointments
                    @endif
                </h1>
                <p class="text-sm text-stone-400 mt-1">Manage shelter visits and consultations.</p>
            </div>
            @if(Auth::user()->role === 'user')
            <a href="{{ route('appointments.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Book Appointment
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($appointments->count())
        <div class="space-y-4">
            @foreach($appointments as $apt)
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-5 flex flex-col sm:flex-row sm:items-center gap-5 hover:border-orange-200 transition-colors">
                <div class="flex items-center gap-4 flex-1">
                    <div class="w-12 h-12 bg-orange-50 border border-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-stone-900">{{ $apt->date_time->format('l, F j, Y') }}</p>
                        <p class="text-sm text-stone-400">
                            {{ $apt->date_time->format('g:i A') }}
                            @if($apt->pet) &bull; Visit to see <span class="font-medium text-orange-600">{{ $apt->pet->name }}</span>
                            @else &bull; General Shelter Visit
                            @endif
                            @if(Auth::user()->role !== 'user') &bull; <span class="text-stone-500">{{ $apt->user->name }}</span> @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    @if($apt->status === 'pending') <span class="badge-pending">Pending</span>
                    @elseif($apt->status === 'approved') <span class="badge-approved">Confirmed</span>
                    @elseif($apt->status === 'cancelled') <span class="badge-rejected">Cancelled</span>
                    @else <span class="badge-completed">Completed</span>
                    @endif

                    @can('manage-pets')
                    @if($apt->status === 'pending')
                    <form action="{{ route('appointments.updateStatus', $apt) }}" method="POST" class="flex gap-2">
                        @csrf @method('PATCH')
                        <button type="submit" name="status" value="approved" class="px-3 py-1.5 bg-green-50 hover:bg-green-500 text-green-700 hover:text-white text-xs font-bold rounded-lg border border-green-200 hover:border-green-500 transition-all">Confirm</button>
                        <button type="submit" name="status" value="cancelled" class="px-3 py-1.5 bg-red-50 hover:bg-red-500 text-red-700 hover:text-white text-xs font-bold rounded-lg border border-red-200 hover:border-red-500 transition-all">Cancel</button>
                    </form>
                    @endif
                    @endcan

                    @if(Auth::user()->id === $apt->user_id && $apt->status === 'pending')
                    <form action="{{ route('appointments.destroy', $apt) }}" method="POST" onsubmit="return confirm('Cancel this appointment?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white text-xs font-bold rounded-lg border border-red-200 transition-all">Cancel</button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $appointments->links() }}</div>
        @else
        <div class="text-center py-20 bg-white rounded-2xl border border-stone-100">
            <div class="text-5xl mb-4">📅</div>
            <h3 class="text-lg font-semibold text-stone-800 mb-2">No appointments scheduled</h3>
            <p class="text-stone-400 mb-6">Book a shelter visit to meet the pets in person.</p>
            <a href="{{ route('appointments.create') }}" class="btn-primary">Book a Visit</a>
        </div>
        @endif
    </div>
</x-app-layout>
