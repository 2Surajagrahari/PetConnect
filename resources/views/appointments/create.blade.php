<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Book an Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-8">
                @if($pet)
                    <div class="mb-6 p-4 bg-indigo-50 dark:bg-slate-800 rounded-xl border border-indigo-100 dark:border-slate-700 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 bg-slate-200">
                            @if($pet->images->count() > 0)
                                <img src="{{ Storage::url($pet->images->first()->image_path) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">You are booking a visit to see {{ $pet->name }}</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Located at {{ $pet->location ?? 'our shelter' }}</p>
                        </div>
                    </div>
                @else
                    <div class="mb-6 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                        <h3 class="font-bold text-slate-900 dark:text-white">General Shelter Visit</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Come visit us to see all available pets.</p>
                    </div>
                @endif

                <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @if($pet)
                        <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Select Date & Time</label>
                        <input type="datetime-local" name="date_time" required class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600 text-slate-900 dark:text-white py-3 px-4 shadow-sm" min="{{ date('Y-m-d\TH:i') }}">
                        @error('date_time')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 dark:bg-slate-800/80 border-l-4 border-blue-500 p-4 rounded-r-xl">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700 dark:text-blue-400">
                                    Please arrive 10 minutes early. Remember to bring a valid ID.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-4 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ url()->previous() }}" class="px-6 py-3 bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-600 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-600 font-bold transition-colors">Cancel</a>
                        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-bold shadow-lg shadow-indigo-500/30 transition-colors">Confirm Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
