<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-stone-900">My Dashboard</h1>
                <p class="text-sm text-stone-400 mt-1">Welcome back, {{ Auth::user()->name }} 👋</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Quick links --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['Find a Pet', route('pets.index'), '🐶'],
                ['Care Guides', route('articles.index'), '📖'],
                ['Book a Visit', route('appointments.create'), '📅'],
                ['My Applications', route('applications.index'), '📋'],
            ] as [$label, $url, $emoji])
            <a href="{{ $url }}" class="bg-white border border-stone-100 rounded-2xl p-5 text-center hover:border-orange-200 hover:bg-orange-50/50 transition-all group shadow-sm">
                <div class="text-3xl mb-2">{{ $emoji }}</div>
                <p class="text-sm font-semibold text-stone-600 group-hover:text-orange-600 transition-colors">{{ $label }}</p>
            </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- My Applications --}}
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-stone-100 flex justify-between items-center">
                    <h2 class="font-bold text-stone-800">My Adoption Applications</h2>
                    <a href="{{ route('applications.index') }}" class="text-sm text-orange-500 hover:text-orange-700 font-semibold">View All</a>
                </div>
                @if($applications->count())
                <div class="divide-y divide-stone-50">
                    @foreach($applications as $app)
                    <div class="px-6 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-stone-100 flex-shrink-0">
                            @if($app->pet && $app->pet->images->count() > 0)
                                <img src="{{ Storage::url($app->pet->images->first()->image_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-lg">🐾</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-stone-800 text-sm truncate">{{ $app->pet->name ?? 'Unknown Pet' }}</p>
                            <p class="text-xs text-stone-400">{{ $app->created_at->diffForHumans() }}</p>
                        </div>
                        @if($app->status === 'pending') <span class="badge-pending">Pending</span>
                        @elseif($app->status === 'approved') <span class="badge-approved">Approved</span>
                        @elseif($app->status === 'rejected') <span class="badge-rejected">Declined</span>
                        @else <span class="badge-completed">Done</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="px-6 py-12 text-center">
                    <div class="text-4xl mb-3">🐾</div>
                    <p class="text-stone-400 text-sm mb-4">You haven't applied for any pets yet.</p>
                    <a href="{{ route('pets.index') }}" class="btn-primary text-sm py-2.5">Find a Pet</a>
                </div>
                @endif
            </div>

            {{-- My Appointments --}}
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-stone-100 flex justify-between items-center">
                    <h2 class="font-bold text-stone-800">My Appointments</h2>
                    <a href="{{ route('appointments.create') }}" class="text-sm text-orange-500 hover:text-orange-700 font-semibold">+ Book New</a>
                </div>
                @if($appointments->count())
                <div class="divide-y divide-stone-50">
                    @foreach($appointments as $apt)
                    <div class="px-6 py-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-stone-800 text-sm">{{ $apt->date_time->format('M j, Y @ g:i A') }}</p>
                                <p class="text-xs text-stone-400 mt-0.5">
                                    @if($apt->pet) Visit: <span class="text-orange-500">{{ $apt->pet->name }}</span>
                                    @else General Shelter Visit @endif
                                </p>
                            </div>
                            @if($apt->status === 'pending') <span class="badge-pending">Pending</span>
                            @elseif($apt->status === 'approved') <span class="badge-approved">Confirmed</span>
                            @elseif($apt->status === 'cancelled') <span class="badge-rejected">Cancelled</span>
                            @else <span class="badge-completed">Done</span>
                            @endif
                        </div>
                        @if($apt->status === 'pending')
                        <form action="{{ route('appointments.destroy', $apt) }}" method="POST" class="mt-2">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600 font-medium transition-colors">Cancel appointment</button>
                        </form>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="px-6 py-12 text-center">
                    <div class="text-4xl mb-3">📅</div>
                    <p class="text-stone-400 text-sm mb-4">No appointments scheduled yet.</p>
                    <a href="{{ route('appointments.create') }}" class="btn-primary text-sm py-2.5">Book a Visit</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
