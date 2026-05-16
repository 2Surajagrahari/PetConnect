<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use Illuminate\Http\Request;

class AdoptionApplicationController extends Controller
{
    // Admin/Shelter or User (filtering logic handles visibility)
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->role === 'admin' || $user->role === 'shelter') {
            $applications = AdoptionApplication::with(['user', 'pet'])->latest()->paginate(15);
        } else {
            $applications = $user->adoptionApplications()->with('pet')->latest()->paginate(15);
        }

        return view('applications.index', compact('applications'));
    }

    // Submit new application
    public function store(Request $request, Pet $pet)
    {
        // Prevent duplicate applications for the same pet
        $exists = $request->user()->adoptionApplications()
            ->where('pet_id', $pet->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have an active application for ' . $pet->name . '.');
        }

        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_details' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'previous_experience' => 'nullable|string',
            'reason' => 'required|string',
            'living_environment' => 'required|string'
        ]);

        $application = $request->user()->adoptionApplications()->create([
            'pet_id' => $pet->id,
            ...$validated
        ]);

        return redirect()->route('dashboard')->with('success', 'Adoption application submitted successfully! We\'ll review it soon.');
    }


    // Show single application details
    public function show(AdoptionApplication $application)
    {
        $application->load('user', 'pet');
        return view('applications.show', compact('application'));
    }

    // Admin/Shelter - Update application status
    public function updateStatus(Request $request, AdoptionApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $application->update(['status' => $validated['status']]);

        // If approved, you might want to automatically update the pet's status too
        if ($validated['status'] === 'approved') {
            $application->pet->update(['status' => 'pending']); // Pending actual pickup
        } elseif ($validated['status'] === 'completed') {
            $application->pet->update(['status' => 'adopted']);
        }

        return back()->with('success', 'Application status updated.');
    }
}
