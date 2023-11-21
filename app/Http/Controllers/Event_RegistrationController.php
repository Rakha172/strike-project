<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Event_Registration;

class Event_RegistrationController extends Controller
{
    public function index()
    {
        $title = Setting::firstOrFail();
        $event_registration = Event_Registration::all();
        return view('event_registration.index', compact('event_registration', 'title'));
    }
    public function create()
    {
        $title = Setting::firstOrFail();
        $events = Event::all();
        $users = User::all();

        $userName = null; // Inisialisasi $userName dengan null
        $event = null; // Inisialisasi $event dengan null

        if (auth()->check()) {
            $user = auth()->user(); // Mengambil pengguna yang sudah login
            $userName = $user->name;
            $event = $user->event;
        }

        return view('landingevent.landingevent', compact('events', 'users', 'userName', 'event', 'title'));
    }

    public function storeEventRegistration(Request $request)
    {
        try {
            $validated = $request->validate([
                'event_id' => 'required',
            ]);

            $event = Event::findOrFail($validated['event_id']);

            // Check if the user is already registered for the event
            $existingRegistration = Event_Registration::where('user_id', auth()->user()->id)
                ->where('event_id', $event->id)
                ->first();

            if ($existingRegistration) {
                return response()->json(['error' => 'You are already registered for this event.']);
            }

            // Perform additional validation or business logic if needed

            // Create a new registration
            $registration = new Event_Registration([
                'user_id' => auth()->user()->id,
                'event_id' => $event->id,
                'payment_status' => 'waiting',
                // Add other fields as needed
            ]);

            $registration->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to register for the event.']);
        }
    }

    public function update(Request $request, Event_Registration $event_registration)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'booth' => 'required',
            'payment_status' => 'required',
            'qualification' => 'required|in:weight,total,special', // Validate the qualification field

        ]);

        $event_registration->update($validated);

        return redirect()->route('event_registration.index')->with('berhasil', "Berhasil diubah");
    }

    public function destroy($id)
    {
        $event_registration = Event_Registration::find($id);
        $event_registration->delete();
        return redirect()->route('event_registration.index')->with('berhasil', "Berhasil dihapus!");
    }
}
