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
        // $results = Result::with('user')->get();
        $results = Result::all();
        return view('result.index', compact('results'));
    }

    public function create()
    {
        $users = User::all();
        $event = Event::all();
        $event_registration = Event_Registration::all();
        // dd($event_registration);
        $userName = null;

        if (auth()->check()) {
            $user = auth()->user(); // Mengambil pengguna yang sudah login
            $userName = $user->name;
            $event = auth()->user()->events;
        }

        return view('result.create', compact('event','event_registration','users','userName'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required', // Pastikan user_id sudah ada
            'events_registration_id' => 'required', // Pastikan events_registration_id sudah ada
            'weight' => 'required',
            'status' => 'required',
        ]);

        $weightInput = $validatedData['weight'];

        if (strpos($weightInput, 'g') !== false) {
            $weightValue = floatval(str_replace('g', '', $weightInput));
            $weightValueInKg = $weightValue / 1000;
        } else {
            $weightValueInKg = floatval($weightInput);
        }
        Result::create([
            'user_id' => $validatedData['user_id'],
            'events_registration_id' => $validatedData['events_registration_id'],
            'weight' => $weightValueInKg,
            'status' => $validatedData['status']
        ]);

        return redirect()->route('result.index')
            ->with('success', 'Data hasil pemancingan berhasil dibuat.');
    }


    public function show(Result $result)
    {
        return view('result.show', compact('result'));
    }

    public function edit(Result $result)
    {
        $users = User::all();
        $event_registration = Event_Registration::all();
        return view('result.edit', compact('result', 'event_registration', 'users'));
    }


    public function update(Request $request, Result $result)
    {
        $validatedData = $request->validate([
            'user'   => 'required',
            'weight' => 'required|string', // misalnya, "1500g"
            'status' => 'required|in:special,regular',
        ]);

        $weightInput = $validatedData['weight'];

        $weightValue = floatval(str_replace('g', '', $weightInput));

        if (strpos($weightInput, 'g') !== false) {
            $weightValueInKg = $weightValue / 1000;
        } else {
            $weightValueInKg = $weightValue;
        }

        dd($weightValueInKg);
        $result->update(['weight' => $weightValueInKg, 'status' => $validatedData['status']]);

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

