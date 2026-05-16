<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-stone-900">Shelter Dashboard</h1>
                <p class="text-sm text-stone-400 mt-1">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full uppercase tracking-wide">{{ Auth::user()->role }}</span>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 flex items-center gap-5">
                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-stone-900">{{ $totalPets }}</p>
                    <p class="text-sm text-stone-400 font-medium">Total Pets</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 flex items-center gap-5">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-stone-900">{{ $availablePets }}</p>
                    <p class="text-sm text-stone-400 font-medium">Available</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 flex items-center gap-5">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-stone-900">{{ $pendingApplications }}</p>
                    <p class="text-sm text-stone-400 font-medium">Pending Reviews</p>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-orange-50 border border-orange-100 rounded-2xl p-6">
            <h2 class="font-bold text-stone-700 mb-4 text-sm uppercase tracking-wide">Quick Actions</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('pets.create') }}" class="btn-primary text-sm py-2.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add New Pet
                </a>
                <a href="{{ route('pets.manage') }}" class="btn-secondary text-sm py-2.5">Manage Pets</a>
                <a href="{{ route('applications.index') }}" class="btn-secondary text-sm py-2.5">Review Applications</a>
                <a href="{{ route('appointments.index') }}" class="btn-secondary text-sm py-2.5">Manage Appointments</a>
                <a href="{{ route('articles.create') }}" class="btn-secondary text-sm py-2.5">Write Care Guide</a>
            </div>
        </div>

        {{-- Recent Applications --}}
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-100 flex justify-between items-center">
                <h2 class="font-bold text-stone-800">Recent Applications</h2>
                <a href="{{ route('applications.index') }}" class="text-sm text-orange-500 hover:text-orange-700 font-semibold">View All →</a>
            </div>
            @if($recentApplications->count())
            <div class="divide-y divide-stone-50">
                @foreach($recentApplications as $app)
                <div class="px-6 py-4 flex items-center gap-4 hover:bg-amber-50/50 transition-colors">
                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-stone-100 flex-shrink-0">
                        @if($app->pet && $app->pet->images->count() > 0)
                            <img src="{{ Storage::url($app->pet->images->first()->image_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-lg">🐾</div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-stone-900 text-sm truncate">{{ $app->applicant_name }} → {{ $app->pet->name ?? '?' }}</p>
                        <p class="text-xs text-stone-400">{{ $app->created_at->diffForHumans() }}</p>
                    </div>
                    @if($app->status === 'pending') <span class="badge-pending">Pending</span>
                    @elseif($app->status === 'approved') <span class="badge-approved">Approved</span>
                    @elseif($app->status === 'rejected') <span class="badge-rejected">Declined</span>
                    @else <span class="badge-completed">Done</span>
                    @endif
                    <a href="{{ route('applications.show', $app) }}" class="text-xs font-semibold text-orange-500 hover:text-orange-700 flex-shrink-0">Review →</a>
                </div>
                @endforeach
            </div>
            @else
            <div class="px-6 py-12 text-center text-stone-400">No applications yet.</div>
            @endif
        </div>
    </div>
</x-app-layout>
