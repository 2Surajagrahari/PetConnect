<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('applications.index') }}" class="text-stone-400 hover:text-orange-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-stone-900">Application #{{ $application->id }}</h1>
                <p class="text-sm text-stone-400 mt-0.5">Submitted {{ $application->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                    <h2 class="font-bold text-stone-800 mb-5 pb-3 border-b border-stone-100">Applicant Details</h2>
                    <dl class="space-y-4">
                        @foreach([
                            'Full Name' => $application->applicant_name,
                            'Contact' => $application->contact_details,
                            'Occupation' => $application->occupation ?? '—',
                        ] as $label => $value)
                        <div class="flex gap-4">
                            <dt class="text-xs font-bold text-stone-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">{{ $label }}</dt>
                            <dd class="text-stone-700 text-sm">{{ $value }}</dd>
                        </div>
                        @endforeach
                        <div class="flex gap-4">
                            <dt class="text-xs font-bold text-stone-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Address</dt>
                            <dd class="text-stone-700 text-sm whitespace-pre-line">{{ $application->address }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                    <h2 class="font-bold text-stone-800 mb-5 pb-3 border-b border-stone-100">Adoption Questionnaire</h2>
                    <div class="space-y-5">
                        <div>
                            <h3 class="text-xs font-bold text-stone-400 uppercase tracking-wide mb-2">Why do they want to adopt?</h3>
                            <p class="text-stone-700 text-sm leading-relaxed bg-amber-50 rounded-xl p-4">{{ $application->reason }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-stone-400 uppercase tracking-wide mb-2">Living Environment</h3>
                            <p class="text-stone-700 text-sm leading-relaxed bg-amber-50 rounded-xl p-4">{{ $application->living_environment }}</p>
                        </div>
                        @if($application->previous_experience)
                        <div>
                            <h3 class="text-xs font-bold text-stone-400 uppercase tracking-wide mb-2">Previous Pet Experience</h3>
                            <p class="text-stone-700 text-sm leading-relaxed bg-amber-50 rounded-xl p-4">{{ $application->previous_experience }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                    <h2 class="font-bold text-stone-800 mb-4 pb-3 border-b border-stone-100">Pet Requested</h2>
                    @if($application->pet)
                    <a href="{{ route('pets.show', $application->pet) }}" class="block group">
                        <div class="w-full h-32 rounded-xl overflow-hidden bg-stone-100 mb-3">
                            @if($application->pet->images->count() > 0)
                                <img src="{{ Storage::url($application->pet->images->first()->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl">🐾</div>
                            @endif
                        </div>
                        <h3 class="font-bold text-stone-900 group-hover:text-orange-600 transition-colors">{{ $application->pet->name }}</h3>
                        <p class="text-sm text-stone-400">{{ $application->pet->breed ?? 'Mixed' }} · {{ $application->pet->age }} yrs</p>
                    </a>
                    @endif
                </div>

                <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                    <h2 class="font-bold text-stone-800 mb-4 pb-3 border-b border-stone-100">Status</h2>
                    <div class="mb-5">
                        @if($application->status === 'pending') <span class="badge-pending">Pending Review</span>
                        @elseif($application->status === 'approved') <span class="badge-approved">Approved</span>
                        @elseif($application->status === 'rejected') <span class="badge-rejected">Declined</span>
                        @else <span class="badge-completed">Completed</span>
                        @endif
                    </div>
                    @can('manage-pets')
                    <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="space-y-3">
                        @csrf @method('PATCH')
                        <div>
                            <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Update Status</label>
                            <select name="status" class="input-field text-sm">
                                @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Declined', 'completed' => 'Completed'] as $val => $label)
                                <option value="{{ $val }}" {{ $application->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center text-sm py-3">Update Status</button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
