<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event_Registration;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $results = Result::all();
        return view('result.create', compact('users', 'events', 'results', 'event_registration'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'participant' => 'required',
            'event_id' => 'nullable|exists:events,id',
            'weight' => 'required',
            'status' => 'required|in:special,regular',
        ]);

        // Mengambil data yang dipilih dari select
        $user_id = $request->input('participant');
        $event_id = $request->input('event_id');

        $user = User::find($user_id);
        $event = Event::find($event_id);

        if (!$user) {
            return redirect()->route('result.create')->with('error', 'User tidak ditemukan.');
        }

        $weightValueInKg = floatval($request->input('weight'));

        $result = new Result;
        $result->user_id = $user->id;
        $result->event_id = $event_id;
        $result->weight = $weightValueInKg;
        $result->status = $request->input('status');
        $result->save();

        if ($result->wasRecentlyCreated) {
            return redirect()->route('result.index')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('result.create')->with('error', 'Gagal menyimpan data');
        }
    }

    public function edit(Result $result)
    {
        $users = User::all();
        $event_registration = Event_Registration::all();
        $event = Event::all();

        return view('result.edit', compact('result', 'users'));
    }

    public function update(Request $request, Result $result)
    {
        $validated = $request->validate([
            'weight' => 'required',
            'status' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $result->update($validated);

        return redirect()->route('result.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Result $result)
    {
        $result->delete();

        return redirect()->route('result.index')->with('success', 'Data berhasil dihapus');
    }
}
