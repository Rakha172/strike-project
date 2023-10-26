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
        // $users = User::all();
        $results = Result::with('user')->get(); // Mengambil semua data hasil dengan data pengguna terkait
        return view('result.index', compact('results'));
    }

    public function create()
    {
        $users = User::all();
        $event_registration = Event_Registration::all();
        $userName = null; // Inisialisasi $userName dengan null
        $event = null; // Inisialisasi $event dengan null

        if (auth()->check()) {
            $user = auth()->user(); // Mengambil pengguna yang sudah login
            $userName = $user->name;
            $event = $user->events;
        }

        return view('result.create', compact('event_registration','users','userName'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'events_registration_id' => 'nullable',
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

    //     $eventRegistration = Event_Registration::find($validatedData['events_registration_id']);
    //      if ($eventRegistration) {
    //     // Buat entri baru di tabel results dengan data yang sesuai
    //     $result = new Result([
    //         'user_id' => $eventRegistration->user_id,
    //         'event_id' => $eventRegistration->event_id,
    //         'weight' => $weightValueInKg,
    //         'status' => $validatedData['status'],
    //     ]);

    //     $result->save();

    //     return redirect()->route('result.index')->with('success', 'Data hasil pemancingan berhasil dibuat.');
    // } else {
    //     return redirect()->back()->with('error', 'Registrasi acara tidak ditemukan.');
    // }

        Result::create(['weight' => $weightValueInKg, 'status' => $validatedData['status']]);

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

