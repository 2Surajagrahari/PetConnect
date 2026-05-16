<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Pet;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // User / Admin - List appointments
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->role === 'admin' || $user->role === 'shelter') {
            $appointments = Appointment::with(['user', 'pet'])->latest()->paginate(15);
        } else {
            $appointments = $user->appointments()->with('pet')->latest()->paginate(15);
        }

        return view('appointments.index', compact('appointments'));
    }

    // User - Show booking form
    public function create(Request $request)
    {
        $pet_id = $request->get('pet_id');
        $pet = $pet_id ? Pet::find($pet_id) : null;
        return view('appointments.create', compact('pet'));
    }

    // User - Store new appointment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'nullable|exists:pets,id',
            'date_time' => 'required|date|after:now',
        ]);

        $request->user()->appointments()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Appointment booked successfully.');
    }

    // Show single appointment details
    public function show(Appointment $appointment)
    {
        $appointment->load('user', 'pet');
        return view('appointments.show', compact('appointment'));
    }

    // Admin/Shelter - Update appointment status
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,cancelled,completed'
        ]);

        $appointment->update(['status' => $validated['status']]);

        return back()->with('success', 'Appointment status updated.');
    }

    // User - Delete/Cancel appointment
    public function destroy(Appointment $appointment)
    {
        // Only allow if pending
        if ($appointment->status === 'pending') {
            $appointment->delete();
            return redirect()->route('dashboard')->with('success', 'Appointment cancelled.');
        }

        return back()->with('error', 'Cannot cancel this appointment.');
    }
}
