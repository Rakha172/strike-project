<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Event_Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Event_RegistrationController extends Controller
{
    public function index()
    {
        $title = Setting::firstOrFail();
        $event_registration = Event_Registration::all();
        return view('event_registration.index', compact('event_registration', 'title'));
    }
    public function create($event_register_id)
    {
        $title = Setting::firstOrFail();
        $events = Event::all();
        $users = User::all();
        $userName = null;
        $event = null;

        if (auth()->check()) {
            $user = auth()->user();
            $userName = $user->name;
            $event = $user->event;
        }

        return view('landingevent.landingevent', compact('events', 'users', 'userName', 'event', 'title', 'event_regist'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'booth' => 'nullable',
        ]);

        // Cek apakah user sudah ada di event_regist
        $existingRegistration = Event_Registration::where('user_id', $validated['user_id'])
            ->where('event_id', $validated['event_id'])
            ->first();

        // jika user sudah ada di event_regist maka akan di arahkan
        if ($existingRegistration) {

            $event_id = $existingRegistration->id;

            return redirect()->route('payment',$event_id)->with('success', 'Lanjutkan Pembayaran');
        }

        // Jika user belum terdaftar, lanjutkan proses pendaftaran
        $validated['payment_status'] = 'waiting';

        $event = Event::find($request->input('event_id'));
        $currentRegistrations = Event_Registration::where('event_id', $event->id)->count();
        $totalBooth = $event->total_booth;

        if ($currentRegistrations >= $totalBooth) {
            return redirect()->route('payment')->with('error', 'Pendaftaran sudah penuh untuk event ini.');
        }

        $latestCode = Event_Registration::query()->where('code', '!=', null)->latest()->first();
        $dateFormat = now()->format('YmdHis');
        $latestThreeDigitsCode = substr($latestCode?->code, -3);
        $codeSequence = sprintf('%03d', intval($latestThreeDigitsCode) + 1);
        $code = $dateFormat . $codeSequence;

        $validated['code'] = $code;

        $eventPrice = substr_replace($event->price, $codeSequence, -6);
        $payment_total = $eventPrice;
        $validated['payment_total'] = $payment_total;

        $validated['regist_date'] = now();

        $addEventRegist = Event_Registration::create($validated);

        return redirect()->route('payment', $addEventRegist->id)->with('success', 'Berhasil Dibuat.');
    }

    public function update(Request $request, Event_Registration $event_registration)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'booth' => 'nullable',
            'payment_status' => 'required',

        ]);

        $event_registration->update($validated);
        return redirect()->route('event_registration.index')->with('berhasil', "Berhasil diubah");
    }
    public function destroy($id)
    {
        $event_registration = Event_Registration::find($id);
        $event_registration->delete();
        return redirect()->route('event_registration.index')->with('berhasil', "Berhasil dihapus!");
    }
}
