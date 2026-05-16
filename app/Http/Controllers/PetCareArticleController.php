<?php

namespace App\Http\Controllers;

use App\Models\PetCareArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetCareArticleController extends Controller
{
    // Public - List all articles
    public function index()
    {
        $articles = PetCareArticle::latest()->paginate(9);
        return view('articles.index', compact('articles'));
    }

    // Public - Show article details
    public function show(PetCareArticle $article)
    {
        return view('articles.show', compact('article'));
    }

    // Admin/Shelter - Show create form
    public function create()
    {
        return view('articles.create');
    }

    // Admin/Shelter - Store new article
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('articles', 'public');
        }

        $request->user()->petCareArticles()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Article created successfully.');
    }

    // Admin/Shelter - Show edit form
    public function edit(PetCareArticle $article)
    {
        return view('articles.edit', compact('article'));
    }

    // Admin/Shelter - Update article
    public function update(Request $request, PetCareArticle $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($article->image_path) {
                Storage::disk('public')->delete($article->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('dashboard')->with('success', 'Article updated successfully.');
    }

    // Admin/Shelter - Delete article
    public function destroy(PetCareArticle $article)
    {
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }
        $article->delete();
        
        return redirect()->route('dashboard')->with('success', 'Article deleted successfully.');
    }
}
