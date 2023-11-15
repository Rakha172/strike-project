<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Event_Registration;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $title = Setting::firstOrFail();
        $events = Event::all();
        foreach ($events as $event) {
            $event->random_both = $event->random_both;
        }
        return view('event.index', compact('title','events'));
    }

    public function show($eventId)
    {
        $title = Setting::firstOrFail();
        // Cari event berdasarkan ID
        $event = Event::find($eventId);

        if (!$event) {
            return redirect()->route('event.index')->with('error', 'Event tidak ditemukan.');
        }

        $users = User::whereHas('event_regist', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })->get();

        return view('event.show', compact('event', 'users', 'title'));
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


    public function create()
    {
        $title = Setting::firstOrFail();
        return view('event.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'total_booth' => 'required',
            'event_date' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'location' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:png,jpg|max:2040',
            'qualification' => 'required|in:weight,total,special,combined,weight special,weight total,total special',
            'start' => 'nullable|date_format:H:i',
            'end' => 'nullable|date_format:H:i',
        ]);

        // Upload gambar untuk field 'image'
        $image = $request->image;
        $slugimage = Str::slug($image->getClientOriginalName());
        $new_image = time() . '_' . $slugimage;
        $image->move('uploads/event-app/', $new_image);


        $events = new Event;
        $events->image = 'uploads/event-app/' . $new_image;
        $events->name = $request->name;
        $events->price = $request->price;
        $events->total_booth = $request->total_booth;
        $events->event_date = $request->event_date;
        $events->location = $request->location;
        $events->description = $request->description;
        $events->qualification = $request->qualification;
        $events->start = $request->start;
        $events->end = $request->end;
        $events->save();

        return redirect()->route('event.index')->with('berhasil', "$request->name Berhasil ditambahkan");
    }

    public function edit(Event $events)
    {
        $title = Setting::firstOrFail();
        return view('event.edit', compact('events', 'title'));
    }

    public function update(Request $request, Event $events)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'total_booth' => 'required',
            'event_date' => 'required',
            'location' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:png,jpg|max:2040',
            'qualification' => 'required|in:weight,total,special,combined,weight special,weight total,total special',
            'start' => 'nullable|date_format:H:i',
            'end' => 'nullable|date_format:H:i',
        ]);

        // Upload gambar untuk field 'image'
        $image = $request->image;
        $slugimage = Str::slug($image->getClientOriginalName());
        $new_image = time() . '_' . $slugimage;
        $image->move('uploads/event-app/', $new_image);

        $events = new Event;

        $events->image = 'uploads/event-app/' . $new_image;
        $events->name = $request->name;
        $events->price = $request->price;
        $events->total_booth = $request->total_booth;
        $events->event_date = $request->event_date;
        $events->location = $request->location;
        $events->description = $request->description;
        $events->qualification = $request->qualification;
        $events->start = $request->start;
        $events->end = $request->end;
        $events->save();


        return redirect()->route('event.index')->with('berhasil', "$request->name Berhasil diubah");
    }

    public function destroy($id)
    {
        $events = Event::find($id);
        $events->delete();

        return redirect()->route('event.index')->with('berhasil', "$events->name Berhasil dihapus");
    }
}
