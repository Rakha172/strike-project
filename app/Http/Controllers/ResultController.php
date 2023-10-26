<?php

namespace App\Http\Controllers;


use App\Models\Event;
use App\Models\Event_Registration;
use App\Models\Result;
use App\Models\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{

    public function index(Request $request)
    {
        return view('result.index', compact('results'));
    }

    public function show()
    {

    }

    public function create(Request $request)
    {
        $user = User::where('name', Auth::user()->name)->get();
        $event_registration = Event_Registration::all();
        $event = Event::find($request->events);
        $result = Result::all();
        return view('result.create', compact('user', 'result', 'event_registration', 'event'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_registration_id' => 'required|exists:events_registration,id',
            'event_id' => 'required|exists:events,id',
            'weight' => 'required',
            'status' => 'required',
        ]);

        // Lanjutkan dengan membuat pesanan baru
        $result = new Result;
        $result->user_id = $request->user_id;
        $result->event_registration_id = $request->event_registration_id;
        $result->event_id = $request->event_id;
        $result->weight = $request->weight;
        $result->status = $request->status;
        $result->save();

        $user = User::where('id', '!=', 1)->get();
        $result = Result::all();
        // Session::flash('sukses','checkout berhasil dilakukan, segera lakukan pembayaran untuk mengyelesaikan order');
        return view('result.create')->with(['user' => $user, 'results' => $result]);



    }
    public function edit(Result $result)
    {
        $users = User::all();
        $event_registration = Event_Registration::all();
        $event_registration->event_name;
        $event = Event::all();
        $event->event_name;

        return view('result.edit', compact('results', 'users', 'events_registration', 'events'));
    }

    public function update(Request $request, Result $result)
    {
        $validated = $request->validate([
            'weight' => 'required',
            'status' => 'required',
            'user_id' => 'required|exists:users,id',
            'event_registration_id' => 'required|exists:events_registration,id',
            'event_id' => 'required|exists:events,id',
        ]);

        $result->update($validated);

        return redirect()->route('result.index')->with('berhasil', "$request->status Berhasil diubah!");
    }

    public function destroy(Result $result)
    {
        $result->delete();

        return redirect()->route('result.index')->with('berhasil', "$result->status Berhasil dihapus!");
    }

}
