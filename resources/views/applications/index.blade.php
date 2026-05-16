<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-stone-900">
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'shelter')
                        All Adoption Applications
                    @else
                        My Applications
                    @endif
                </h1>
                <p class="text-sm text-stone-400 mt-1">Track and manage adoption requests.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($applications->count())
        <div class="space-y-4">
            @foreach($applications as $app)
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6 flex flex-col md:flex-row md:items-center gap-5 hover:border-orange-200 transition-colors">
                <div class="w-14 h-14 rounded-xl overflow-hidden bg-stone-100 flex-shrink-0">
                    @if($app->pet && $app->pet->images->count() > 0)
                        <img src="{{ Storage::url($app->pet->images->first()->image_path) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-2xl">🐾</div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-3 mb-1">
                        <h3 class="font-bold text-stone-900">{{ $app->applicant_name }}</h3>
                        <span class="text-stone-300">→</span>
                        <span class="font-semibold text-orange-600">{{ $app->pet->name ?? 'Unknown Pet' }}</span>
                        @if($app->status === 'pending') <span class="badge-pending">Pending Review</span>
                        @elseif($app->status === 'approved') <span class="badge-approved">Approved</span>
                        @elseif($app->status === 'rejected') <span class="badge-rejected">Declined</span>
                        @else <span class="badge-completed">Completed</span>
                        @endif
                    </div>
                    <p class="text-sm text-stone-400">{{ $app->contact_details }} &bull; Applied {{ $app->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="{{ route('applications.show', $app) }}" class="btn-secondary text-sm py-2">View Details</a>
                    @can('manage-pets')
                    @if($app->status === 'pending')
                    <form action="{{ route('applications.updateStatus', $app) }}" method="POST" class="flex gap-2">
                        @csrf @method('PATCH')
                        <button type="submit" name="status" value="approved" class="px-3 py-2 bg-green-50 hover:bg-green-500 text-green-700 hover:text-white text-sm font-semibold rounded-xl border border-green-200 hover:border-green-500 transition-all">Approve</button>
                        <button type="submit" name="status" value="rejected" class="px-3 py-2 bg-red-50 hover:bg-red-500 text-red-700 hover:text-white text-sm font-semibold rounded-xl border border-red-200 hover:border-red-500 transition-all">Decline</button>
                    </form>
                    @endif
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $applications->links() }}</div>
        @else
        <div class="text-center py-20 bg-white rounded-2xl border border-stone-100">
            <div class="text-5xl mb-4">📋</div>
            <h3 class="text-lg font-semibold text-stone-800 mb-2">No applications yet</h3>
            <p class="text-stone-400">Applications will appear here once users start applying to adopt pets.</p>
            <a href="{{ route('pets.index') }}" class="btn-primary mt-6">Browse Pets</a>
        </div>
        @endif
    </div>
</x-app-layout>
