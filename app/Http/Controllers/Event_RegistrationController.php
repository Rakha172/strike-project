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

        $userName = null; // Inisialisasi $userName dengan null
        $event = null; // Inisialisasi $event dengan null

        if (auth()->check()) {
            $user = auth()->user(); // Mengambil pengguna yang sudah login
            $userName = $user->name;
            $event = $user->events;
        }

        return view('landingevent.regisevent', compact('events', 'users', 'userName', 'event'));
    }

    public function store(Request $request)
    {
        // Ambil semua event registration yang sudah ada untuk pengguna dan event yang sedang diinputkan
        $existingRegistrations = Event_Registration::where('user_id', auth()->user()->id)
            ->where('event_id', $request->input('event_id'))
            ->get();

        // Jika sudah ada event registration, beri pesan kesalahan
        if ($existingRegistrations->isNotEmpty()) {
            return redirect()->route('regisevent')
                ->with('error', 'Anda sudah terdaftar untuk acara ini.');
        }

        // Cek apakah booth sudah digunakan dalam event yang sama
        $booth = $request->input('booth');
        $existingBoothRegistration = Event_Registration::where('event_id', $request->input('event_id'))
            ->where('booth', $booth)
            ->first();

        if ($existingBoothRegistration) {
            return redirect()->route('regisevent')
                ->with('error', 'Booth tersebut sudah digunakan. Silakan pilih booth lain.');
        }

        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'booth' => 'required',
        ]);

        $validated['payment_status'] = 'waiting';

        Event_Registration::create($validated);

        return redirect('/dashboard')->with('success', 'Data berhasil dibuat.');
    }

    public function update(Request $request, Event_Registration $event_registration)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'booth' => 'required',
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
