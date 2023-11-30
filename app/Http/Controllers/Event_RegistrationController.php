<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Event_Registration;
use Illuminate\Support\Facades\Http;

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

        $userName = null;
        $event = null;

        if (auth()->check()) {
            $user = auth()->user();
            $userName = $user->name;
            $event = $user->event;
        }

        return view('landingevent.regisevent', compact('events', 'users', 'userName', 'event', 'title'));
    }

    public function store(Request $request)
    {
        $setting = Setting::first();
        $apiKey = $setting->api_key;
        $sender = $setting->sender;
        $user = auth()->user();
        $event = Event::find($request->input('event_id'));

        $existingRegistrations = Event_Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->get();

        if ($existingRegistrations->isNotEmpty()) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar untuk acara ini.');
        }

        $booth = $request->input('booth');
        $existingBoothRegistration = Event_Registration::where('event_id', $event->id)
            ->where('booth', $booth)
            ->first();

        if ($existingBoothRegistration) {
            return redirect()->back()->with('error', 'Booth tersebut sudah digunakan. Silakan pilih booth lain.');
        }

        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'booth' => 'nullable',
        ]);

        $validated['payment_status'] = 'waiting';

        $currentRegistrations = Event_Registration::where('event_id', $event->id)->count();
        $totalBooth = $event->total_booth;

        if ($currentRegistrations >= $totalBooth) {
            return redirect()->back()->with('error', 'Pendaftaran sudah penuh untuk event ini.');
        }

        Event_Registration::create($validated);

        $message = "Halo, {$user->name}! 🌟 Selamat! Anda telah terdaftar untuk acara '{$event->name}' yang akan diselenggarakan pada 🗓️ {$event->event_date}. Registrasi Anda sedang dalam tahap verifikasi pembayaran. Mohon segera menyelesaikan pembayaran untuk menyelesaikan pendaftaran. Terima kasih atas partisipasinya! 🎉";
        $recipientNumber = $user->phone_number;
        $apiKey = $setting->api_key;
        $sender = $setting->sender;
        $endpoint = $setting->endpoint;

        try {
            $response = Http::post($endpoint, [
                'api_key' => $apiKey,
                'sender' => $sender,
                'number' => $recipientNumber,
                'message' => $message,
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Berhasil Dibuat.');
            } else {
                throw new \Exception('Failed to send WhatsApp notification');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Event_Registration $event_registration)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'booth' => 'nullable',
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
