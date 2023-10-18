<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('event.index', compact('events'));
    }

    public function show(Event $event)
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
            'event_date' => 'required',
            'location' => 'required',
            'description' => 'required',
            'category' => 'required',
        ]);

        Event::create($validated);

        return redirect()->route('event.index')->with('berhasil', "$request->name Berhasil ditambahkan");
    }

    public function edit(Event $event)
    {
        return view('event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required',
            'event_date' => 'required',
            'location' => 'required',
            'description' => 'required',
            'category' => 'required',
        ]);

        $event->update($validated);

        return redirect()->route('event.index')->with('berhasil', "$request->name Berhasil diubah");
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return redirect()->route('event.index')->with('berhasil', "$event->name Berhasil dihapus");
    }
}