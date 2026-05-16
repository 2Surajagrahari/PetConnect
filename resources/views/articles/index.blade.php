<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-stone-900">Pet Care Guides</h1>
        <p class="text-sm text-stone-400 mt-1">Expert advice for happy, healthy pets.</p>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @can('manage-pets')
        <div class="mb-8 flex justify-between items-center">
            <p class="text-stone-500 text-sm">{{ $articles->total() }} guide{{ $articles->total() !== 1 ? 's' : '' }} published</p>
            <a href="{{ route('articles.create') }}" class="btn-primary text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Write New Guide
            </a>
        </div>
        @endcan

        @if($articles->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
            $categoryImages = [
                'dogs' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=600&q=80',
                'cats' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80',
                'birds' => 'https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?auto=format&fit=crop&w=600&q=80',
                'nutrition' => 'https://images.unsplash.com/photo-1568640347023-a616a30bc3bd?auto=format&fit=crop&w=600&q=80',
                'training' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=600&q=80',
                'default' => 'https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=600&q=80',
            ];
            @endphp
            @foreach($articles as $article)
            @php
                $cat = strtolower($article->category);
                $imgFallback = $categoryImages['default'];
                foreach ($categoryImages as $key => $url) {
                    if ($key !== 'default' && str_contains($cat, $key)) {
                        $imgFallback = $url; break;
                    }
                }
            @endphp
            <div class="card group flex flex-col h-full">
                <div class="relative h-48 overflow-hidden bg-stone-100">
                    @if($article->image_path)
                        <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <img src="{{ $imgFallback }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 bg-white/90 backdrop-blur-sm text-orange-600 font-bold rounded-full text-xs shadow-sm">{{ ucfirst($article->category) }}</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-lg font-bold text-stone-900 mb-2 line-clamp-2 leading-snug" style="font-family:'Playfair Display',serif">{{ $article->title }}</h3>
                    <p class="text-stone-400 text-sm leading-relaxed line-clamp-3 mb-4">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                    <div class="mt-auto flex items-center justify-between pt-4 border-t border-stone-100">
                        <span class="text-xs text-stone-400">By {{ $article->user->name ?? 'Staff' }}</span>
                        <a href="{{ route('articles.show', $article) }}" class="text-sm font-semibold text-orange-500 hover:text-orange-700 transition-colors flex items-center gap-1">
                            Read More
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-10">{{ $articles->links() }}</div>
        @else
        <div class="text-center py-20 bg-white rounded-2xl border border-stone-100">
            <div class="text-5xl mb-4">📖</div>
            <h3 class="text-xl font-bold text-stone-800 mb-2">No guides yet</h3>
            <p class="text-stone-400">Check back soon for expert pet care advice.</p>
        </div>
        @endif
    </div>
</x-app-layout>
