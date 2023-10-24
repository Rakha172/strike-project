<?php

namespace App\Http\Controllers;

use App\Models\Event_Registration;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class Event_RegistrationController extends Controller
{
    public function index()
    {
        $event_registration = Event_Registration::all();
        return view('event_registration.index', compact('event_registration'));
    }

    public function create()
    {
        $events = Event::all();
        $users = User::all();

        $user = auth()->user(); // Mengambil pengguna yang sudah login
        $userName = $user->name;
        $event = $user->events;

        return view('landingevent.regisevent', compact('events', 'users', 'userName', 'event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        // Tambahkan kolom "payment_status" ke dalam data yang akan disimpan
        $validated['payment_status'] = 'waiting';

        Event_Registration::create($validated);

        return redirect('/dashboard')->with('success', 'Data berhasil dibuat.');
    }


    public function edit(Event_Registration $event_registration)
    {
        $users = User::all();
        $event = Event::all();


        return view('event_registration.edit', compact('event_registration', 'users', 'event'));
    }



    public function update(Request $request, Event_Registration $event_registration)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'payment_status' => 'required',
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
