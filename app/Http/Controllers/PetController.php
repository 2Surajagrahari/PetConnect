<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PetImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    // Public - List all pets
    public function index(Request $request)
    {
        $query = Pet::where('status', 'available')->with('images');

        // Simple filtering
        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }
        if ($request->filled('breed')) {
            $query->where('breed', 'like', '%' . $request->breed . '%');
        }
        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $pets = $query->paginate(12);

        return view('pets.index', compact('pets'));
    }

    // Public - Show pet details
    public function show(Pet $pet)
    {
        $pet->load('images', 'user');
        return view('pets.show', compact('pet'));
    }

    // Admin/Shelter - Manage Pets List
    public function manage()
    {
        $pets = Pet::with('images')->latest()->paginate(15);
        return view('pets.manage', compact('pets'));
    }

    // Admin/Shelter - Show create form
    public function create()
    {
        return view('pets.create');
    }

    // Admin/Shelter - Store new pet
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'nullable|in:Dog,Cat,Bird,Rabbit,Fish,Other',
            'age' => 'nullable|integer|min:0',
            'breed' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female,Unknown',
            'vaccination_status' => 'nullable|string|max:255',
            'health_condition' => 'nullable|string|max:255',
            'size' => 'nullable|in:Small,Medium,Large',
            'color' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $pet = $request->user()->pets()->create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('pets', 'public');
                $pet->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('pets.manage')->with('success', 'Pet added successfully.');
    }

    // Admin/Shelter - Show edit form
    public function edit(Pet $pet)
    {
        return view('pets.edit', compact('pet'));
    }

    // Admin/Shelter - Update pet
    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'nullable|in:Dog,Cat,Bird,Rabbit,Fish,Other',
            'age' => 'nullable|integer|min:0',
            'breed' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female,Unknown',
            'vaccination_status' => 'nullable|string|max:255',
            'health_condition' => 'nullable|string|max:255',
            'size' => 'nullable|in:Small,Medium,Large',
            'color' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:available,pending,adopted'
        ]);

        $pet->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('pets', 'public');
                $pet->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('pets.manage')->with('success', 'Pet updated successfully.');
    }

    // Admin/Shelter - Delete pet
    public function destroy(Pet $pet)
    {
        foreach ($pet->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $pet->delete();
        
        return redirect()->route('pets.manage')->with('success', 'Pet deleted successfully.');
    }
}
