<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('articles.show', $article) }}" class="text-stone-400 hover:text-orange-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-2xl font-bold text-stone-900">Edit: {{ Str::limit($article->title, 40) }}</h1>
        </div>
    </x-slot>

    <div class="py-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Article Title *</label>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}" required class="input-field text-lg font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Category *</label>
                        <select name="category" required class="input-field">
                            @foreach(['Dogs', 'Cats', 'Birds', 'Rabbits', 'Nutrition', 'Training', 'Grooming', 'Health', 'Other'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $article->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($article->image_path)
                    <div>
                        <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Current Cover Photo</label>
                        <div class="h-32 rounded-xl overflow-hidden bg-stone-100">
                            <img src="{{ Storage::url($article->image_path) }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    @endif
                    <div>
                        <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">{{ $article->image_path ? 'Replace Cover Photo' : 'Cover Photo' }}</label>
                        <label class="block cursor-pointer">
                            <div class="border-2 border-dashed border-stone-200 hover:border-orange-300 rounded-xl p-6 text-center transition-colors">
                                <div class="text-2xl mb-1">📷</div>
                                <p class="text-xs text-stone-400">Click to upload a new image</p>
                            </div>
                            <input type="file" name="image" accept="image/*" class="hidden">
                        </label>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-2">Content *</label>
                        <textarea name="content" rows="16" required class="input-field resize-none">{{ old('content', $article->content) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="btn-primary px-8 py-4">Save Changes</button>
                <a href="{{ route('articles.show', $article) }}" class="btn-secondary py-4">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
