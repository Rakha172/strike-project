<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Event_Registration;
use App\Models\Setting;
use App\Models\Result;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $title = Setting::firstOrFail();
        $events = Event::all();
        foreach ($events as $event) {
            $event->random_both = $event->random_both;
        }
        return view('operator.index', compact('title','events'));
    }

    public function show($eventId)
    {
        $title = Setting::firstOrFail();
        // Cari event berdasarkan ID
        $event = Event::find($eventId);

        if (!$event) {
            return redirect()->route('operator-event')->with('error', 'Event tidak ditemukan.');
        }

        $users = User::whereHas('event_regist', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })->get();

        return view('operator.show', compact('event', 'users', 'title'));
    }





    public function reduceBoth(Request $request, $eventId)
    {
        $event = Event::find($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Mengurangkan jumlah 'both' sesuai dengan logika yang Anda inginkan.
        // Contoh: mengurangkan satu dari jumlah 'both' saat permintaan diproses.
        $event->both = $event->both - 1;

        // Simpan perubahan pada event
        $event->save();

        return response()->json(['message' => 'Both reduced successfully']);
    }


    public function indexop(Event $event)
    {
        $title = Setting::firstOrFail();
        $results = Result::all();

        return view('result.index', compact('results', 'event', 'title'));
    }

    public function create(Event $event)
    {

        $title = Setting::firstOrFail();
        $users = User::all();
        $event_registration = $event->event_regist()->get();
        $results = Result::where('event_id', $event->id)->get();

        if (!$event) {
            return redirect()->route('event.index')->with('error', 'Event tidak ditemukan.');
        }

        return view('result.create', compact('users', 'results', 'event_registration', 'event', 'title'));
    }


    public function store(Request $request, Event $event)
    {

        $request->validate([
            'participant' => 'required',
            'weight' => 'required',
            'status' => 'required|in:special,regular',
        ]);

        $user = User::find($request->input('participant'));

        if (!$user) {
            return redirect()->route('result.create', ['event' => $event->id])->with('error', 'User tidak ditemukan.');
        }

        $result = new Result([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'weight' => floatval($request->input('weight')),
            'status' => $request->input('status'),
        ]);

        $result->save();

        return redirect()->route('result.index', ['event' => $event->id])->with('success', 'Data berhasil disimpan');
    }
    public function edit(Result $result)
    {

        // Get the associated event for this result
        $event = $result->event;

        // Periksa apakah event ada atau tidak
        if (!$event) {
            return redirect()->route('event.index')->with('error', 'Event tidak ditemukan.');
        }

        $event_registration = $event->event_regist()->get();
        $results = Result::where('event_id', $event->id)->get();

        return view('result.edit', compact('results', 'event_registration', 'event', 'result'));
    }

    public function update(Request $request, Result $result)
    {
        // Get the associated event for this result
        $event = $result->event;

        // Periksa apakah event ada atau tidak
        if (!$event) {
            return redirect()->route('event.index')->with('error', 'Event tidak ditemukan.');
        }

        $validated = $request->validate([
            'weight' => 'required|numeric',
            'status' => 'required|in:special,regular',
            'participant' => 'required',
        ]);

        $result->update([
            'weight' => $validated['weight'],
            'status' => $validated['status'],
            'participant' => $validated['participant'],
        ]);

        return redirect()->route('result.index', ['event' => $event->id])->with('success', 'Data berhasil diperbarui');
    }


    public function destroy(Result $result)
    {
        $event = $result->event;

        $result->delete();

        return redirect()->route('result.index', ['event' => $event->id])->with('success', 'Data berhasil dihapus');
    }
}
