<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Pastikan ini di atas kelas Controller

use App\Models\Event;
use App\Models\User;
use App\Models\Event_Registration;
use App\Models\Setting;
use App\Models\Result;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Console\View\Components\Alert;

class OperatorController extends Controller
{
    public function index()
    {
        $title = Setting::firstOrFail();
        $events = Event::all();
        foreach ($events as $event) {
            $event->random_both = $event->random_both;
        }
        return view('operator.index', compact('title', 'events'));
    }

    public function show($eventId)
    {
        $title = Setting::firstOrFail();
        // Cari event berdasarkan ID
        $event = Event::find($eventId);

        if (!$event) {
            return redirect()->route('operator-event')->with('error', 'Event tidak ditemukan.');
        }

        $users = User::whereHas('event_regist', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })->get();

        return view('operator.show', compact('event', 'users', 'title'));
    }

    public function reduceBoth(Request $request, $eventId)
    {
        $event = Event::find($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }


        $event->both = $event->both - 1;

        $event->save();

        return response()->json(['message' => 'Both reduced successfully']);
    }

    public function indexop(Event $event)
    {
        $title = Setting::firstOrFail();
        $results = Result::all();

        return view('operator.index-result', compact('results', 'event', 'title'));
    }

    public function create(Event $event)
    {

        $title = Setting::firstOrFail();
        $users = User::all();
        $event_registration = $event->event_regist()->get();
        $results = Result::where('event_id', $event->id)->get();

        if (!$event) {
            return redirect()->route('eventsop.index')->with('error', 'Event tidak ditemukan.');
        }

        return view('operator.create-result', compact('users', 'results', 'event_registration', 'event', 'title'));
    }


    public function store(Request $request, Event $event)
    {
        $request->validate([
            'participant' => 'required',
            'weight' => 'required',
            'status' => 'required|in:special,regular',
            'image_data' => 'required',
        ]);

        $user = User::find($request->input('participant'));

        if (!$user) {
            return redirect()->route('result.create', ['event' => $event->id])->with('error', 'User tidak ditemukan.');
        }

        $result = new Result([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'weight' => floatval($request->input('weight')),
            'status' => $request->input('status'),
            'image_path' => $this->saveImage($request->input('image_data')),
        ]);

        $result->save();

        return redirect()->route('resultop.index', ['event' => $event->id])->with('success', 'Data berhasil disimpan');
    }

    private function saveImage($imageData)
    {
        $folderPath = 'images/results/';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = 'result_' . time() . '.png';
        $filePath = $folderPath . $imageName;
        file_put_contents($filePath, base64_decode($image));

        return $filePath;
    }

    public function edit(Result $result)
    {

        $event = $result->event;

        if (!$event) {
            return redirect()->route('eventsop.index')->with('error', 'Event tidak ditemukan.');
        }

        $event_registration = $event->event_regist()->get();
        $results = Result::where('event_id', $event->id)->get();

        return view('operator.edit-result', compact('results', 'event_registration', 'event', 'result'));
    }

    public function update(Request $request, Result $result)
    {
        $event = $result->event;
        if (!$event) {
            return redirect()->route('eventsop.index')->with('error', 'Event tidak ditemukan.');
        }

        $validated = $request->validate([
            'weight' => 'required|numeric',
            'status' => 'required|in:special,regular',
            'participant' => 'required',
            'image_data' => 'nullable|string', // Tambahkan validasi untuk data gambar (opsional)
        ]);

        $imagePath = $validated['image_data'] ?? null;

        // Tambahkan pengecekan panjang data gambar sebelum update
        if ($imagePath !== null && strlen($imagePath) > 2000) {
            return redirect()->back()->with('error', 'Ukuran gambar terlalu besar.');
        }

        $result->update([
            'weight' => $validated['weight'],
            'status' => $validated['status'],
            'participant' => $validated['participant'],
            'image_path' => $imagePath ?? $result->image_path,
        ]);

        return redirect()->route('resultop.index', ['event' => $event->id])->with('success', 'Data berhasil diperbarui');
    }


    public function showAttendedPage()
    {
        return view('operator.attended');
    }
    public function scan(Request $request)
    {
        try {
            $eventRegistrationId = $request->input('event_registration_id');
            Log::info('Received scanned event registration ID: ' . $eventRegistrationId);

            $eventRegistration = Event_Registration::find($eventRegistrationId);

            if ($eventRegistration) {
                Log::info('Found event registration with ID: ' . $eventRegistrationId);

                if ($eventRegistration->payment_status === 'payed') {
                    // Ubah status pembayaran menjadi "attended"
                    $eventRegistration->update(['payment_status' => 'attended']);
                    Log::info('Payment status updated to "attended" for event registration ID: ' . $eventRegistrationId);

                    return redirect()->route('eventsop.index')->with('success', 'Status pembayaran diubah menjadi attended.');
                } else {
                    Log::warning('Payment status is not "payed" for event registration ID: ' . $eventRegistrationId);
                    return back()->with('warning', 'Status pembayaran tidak sesuai');
                }
            } else {
                Log::warning('Event Registration not found for ID: ' . $eventRegistrationId);
                return redirect()->back()->with('failed', 'Data registrasi acara tidak ditemukan');
            }
        } catch (\Exception $e) {
            Log::error('Error in scan method: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan dalam pemindaian.');
        }
    }
}








