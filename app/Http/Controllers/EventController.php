<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('event.index', ['events' => $events]);
    }

    public function show(Event $events)
    {
        return view('event.show', compact('event'));
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'total_booth' => 'required',
            'event_date' => 'required',
            'location' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:png,jpg|max:2040',
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
        $events->save();

        return redirect()->route('event.index')->with('berhasil', "$request->name Berhasil ditambahkan");
    }

    public function edit(Event $events)
    {
        return view('event.edit', compact('event'));
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

