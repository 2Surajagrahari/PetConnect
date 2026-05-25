<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('articles.index') }}" class="text-stone-400 hover:text-orange-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span class="px-2.5 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full">{{ ucfirst($article->category) }}</span>
        </div>
    </x-slot>

    <div class="py-16 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($article->image_path)
        <div class="w-full h-80 md:h-96 rounded-3xl overflow-hidden bg-stone-100 mb-12 shadow-sm border border-stone-100">
            <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
        </div>
        @endif

        <h1 class="text-4xl md:text-5xl font-bold text-stone-900 mb-6 leading-tight" style="font-family:'Playfair Display',serif">{{ $article->title }}</h1>
        <div class="flex items-center gap-4 text-sm text-stone-400 mb-10 pb-6 border-b border-stone-100">
            <span class="flex items-center gap-1.5">
                <div class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 text-xs font-bold">{{ strtoupper(substr($article->user->name ?? 'S', 0, 1)) }}</div>
                {{ $article->user->name ?? 'Shelter Staff' }}
            </span>
            <span>&bull;</span>
            <span>{{ $article->created_at->format('F j, Y') }}</span>
            @can('manage-pets')
            <span class="ml-auto flex gap-3">
                <a href="{{ route('articles.edit', $article) }}" class="text-blue-500 hover:text-blue-700 font-medium transition-colors">Edit</a>
                <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Delete this article?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition-colors">Delete</button>
                </form>
            </span>
            @endcan
        </div>

        <div class="prose prose-lg prose-stone max-w-none 
                    prose-headings:font-bold prose-headings:text-stone-900 prose-headings:font-serif
                    prose-p:text-stone-600 prose-p:leading-relaxed 
                    prose-li:text-stone-600 
                    prose-strong:text-stone-900
                    prose-a:text-orange-500 prose-a:font-semibold prose-a:no-underline hover:prose-a:underline">
            {!! Str::markdown($article->content) !!}
        </div>

        <div class="mt-12 p-6 bg-orange-50 rounded-2xl border border-orange-100 flex items-center gap-5">
            <div class="text-4xl">🐾</div>
            <div>
                <h3 class="font-bold text-stone-900 mb-1">Found a pet you love?</h3>
                <p class="text-stone-500 text-sm mb-3">Browse our available pets and start the adoption process today.</p>
                <a href="{{ route('pets.index') }}" class="btn-primary text-sm py-2.5">Find a Pet →</a>
            </div>
        </div>
    </div>
</x-app-layout>
