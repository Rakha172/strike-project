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

    public function store(Request $request)
    {
        // Ambil semua event registration yang sudah ada untuk pengguna dan event yang sedang diinputkan
        $existingRegistrations = Event_Registration::where('user_id', auth()->user()->id)
            ->where('event_id', $request->input('event_id'))
            ->get();

        // Jika sudah ada event registration, beri pesan kesalahan
        if ($existingRegistrations->isNotEmpty()) {
            return redirect()->route('landingevent')
                ->with('error', 'Anda sudah terdaftar untuk acara ini.');
        }

        // Cek apakah booth sudah digunakan dalam event yang sama
        $booth = $request->input('booth');
        $existingBoothRegistration = Event_Registration::where('event_id', $request->input('event_id'))
            ->where('booth', $booth)
            ->first();

        if ($existingBoothRegistration) {
            return redirect()->route('landingevent')
                ->with('error', 'Booth tersebut sudah digunakan. Silakan pilih booth lain.');
        }

        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'booth' => 'required',
            'qualification' => 'required|in:weight,total,special', // Validate the qualification field
        ]);

        $validated['payment_status'] = 'waiting';

        // Periksa jumlah pendaftar
        $event = Event::find($request->input('event_id'));
        $currentRegistrations = Event_Registration::where('event_id', $event->id)->count();
        $totalBooth = $event->total_booth;

        if ($currentRegistrations >= $totalBooth) {
            return redirect()->route('landingevent')->with('error', 'Pendaftaran sudah penuh untuk event ini.');
        }

        Event_Registration::create($validated);

        $eventRegistration = Event_Registration::create($validated);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Booking successful']);
    }

        return redirect('/landingevent')->with('success', 'Berhasil Dibuat.');
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
