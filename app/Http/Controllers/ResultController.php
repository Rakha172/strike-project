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
        $user = User::where('name', Auth::user()->name)->first();
        $event_registration = Event_Registration::all();
        $results = Result::all();
        return view('result.create', compact('user', 'results', 'event_registration'));
    }

  public function store(Request $request)
{
    $request->validate([
        'participant' => 'required',
        'event_id' => 'nullable|exists:events,id',
        'weight' => 'required',
        'status' => 'required|in:special,regular',
    ]);

    $user = auth()->user();
    $weightInput = $request->input('weight');

    if (strpos($weightInput, 'g') !== false) {
        $weightValue = floatval(str_replace('g', '', $weightInput));
        $weightValueInKg = $weightValue / 1000;
    } else {
        $weightValueInKg = floatval($weightInput);
    }

    $result = new Result;
    $result->user_id = $user->id;
    $result->weight = $weightValueInKg;
    // $result->status = $request->status;
    $result->status = $request->input('status');
    $result->save();

    // Tambahkan periksaan
    if ($result->wasRecentlyCreated) {
        return redirect()->route('result.index')->with('success', 'Data berhasil disimpan');
    } else {
        return redirect()->route('result.index')->with('error', 'Gagal menyimpan data');
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
