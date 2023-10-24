<?php

namespace App\Http\Controllers;

use App\Models\Event_Registration;
use App\Models\User;
use App\Models\Event;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::all();
        return view('result.index', compact('results'));
    }

    public function create()
    {
        $users = User::all();
        $events = Event::all();
        $event_registration = Event_Registration::all();
        return view('result.create', compact('users','events','event_registration'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required',
            'user_id' => 'required',
            'events_registration_id' => 'nullable',
            'fish_count' => 'required',
            'weight' => 'required',
            'status' => 'required',
        ]);

        Result::create($validatedData);

        return redirect()->route('result.index')->with('success', 'Hasil berhasil ditambahkan.');
    }

    public function show(Result $result)
    {
        return view('result.show', compact('result'));
    }

    public function edit(Result $result)
    {
        $users = User::all();
        $events = Event::all();
        $event_registration = Event_Registration::all();
        return view('result.edit', compact('result','users','events','event_registration'));
    }

    public function update(Request $request, Result $result)
    {
        $validatedData = $request->validate([
            'event_id' => 'required',
            'user_id' => 'required',
            'fish_count' => 'required|integer',
            'weight' => 'required',
            'status' => 'required|in:special,regular',
        ]);

        $result->update($validatedData);

        return redirect()->route('result.index')
            ->with('success', 'Data hasil pemancingan berhasil diperbarui.');
    }

    public function destroy(Result $result)
    {
        $result->delete();

        return redirect()->route('result.index')
            ->with('success', 'Data hasil pemancingan berhasil dihapus.');
    }

}

