<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPets = Pet::where('status', 'available')->with('images')->latest()->take(6)->get();
        
        $stats = [
            'total_pets' => Pet::count(),
            'adopted_pets' => Pet::where('status', 'adopted')->count(),
            'available_pets' => Pet::where('status', 'available')->count(),
        ];

        return view('home', compact('featuredPets', 'stats'));
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin' || $user->role === 'shelter') {
            return view('dashboard.admin', [
                'totalPets' => Pet::count(),
                'availablePets' => Pet::where('status', 'available')->count(),
                'pendingApplications' => \App\Models\AdoptionApplication::where('status', 'pending')->count(),
                'recentApplications' => \App\Models\AdoptionApplication::with(['user', 'pet'])->latest()->take(5)->get()
            ]);
        }

        return view('dashboard.user', [
            'applications' => $user->adoptionApplications()->with('pet')->get(),
            'appointments' => $user->appointments()->with('pet')->get(),
            'favorites' => $user->favorites()->with('pet')->get()
        ]);
    }
}
