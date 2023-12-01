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
use Illuminate\Support\Facades\Http;

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
        $event_registration = $event->event_regist()->where('payment_status', 'attended')->get();
        $results = Result::where('event_id', $event->id)->get();

        $users = User::whereIn('id', $event_registration->pluck('user_id'))->get();

        if (!$event) {
            return redirect()->route('eventsop.index')->with('error', 'Event tidak ditemukan.');
        }

        return view('operator.create-result', compact('users', 'results', 'event_registration', 'event', 'title'));
    }

    public function store(Request $request, Event $event)
    {
        // Validasi input
        $request->validate([
            'participant' => 'required',
            'weight' => 'required',
            'status' => 'required|in:special,regular',
            'image_data' => 'required',
        ]);

        // Temukan pengguna berdasarkan ID yang diberikan dalam request
        $user = User::find($request->input('participant'));

        if (!$user) {
            return redirect()->route('result.create', ['event' => $event->id])->with('error', 'User tidak ditemukan.');
        }

        // Simpan hasil dari pengguna yang terlibat dalam acara
        $result = new Result([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'weight' => floatval($request->input('weight')),
            'status' => $request->input('status'),
            'image_path' => $this->saveImage($request->input('image_data')),
        ]);

        $result->save();

        // Pesan untuk pengguna berdasarkan input mereka
        $userMessage = "Halo, {$user->name}! 🎉\n\nTerima kasih telah bergabung dalam acara ini.\n\nBerikut adalah detail laporan ikan Anda:\nBerat Ikan: {$result->weight} kg\nStatus Ikan: {$result->status} 🐟🌟";
        $userRecipientNumber = $user->phone_number;

        // Mengirim pesan ke pengguna berdasarkan input mereka
        $this->sendWhatsAppMessage($userMessage, $userRecipientNumber);

        // Mengumpulkan informasi hasil dari semua partisipan dalam acara
        $results = Result::where('event_id', $event->id)->get();

        // Menyiapkan pesan untuk hasil dari semua partisipan
        $eventMessage = "🎉 Inilah hasil untuk acara '{$event->name}':\n\n";

        foreach ($results as $result) {
            $participant = $result->user->name;
            $weight = $result->weight;
            $status = $result->status;

            // Tambahkan informasi hasil untuk setiap partisipan ke pesan
            $eventMessage .= "Participant: {$participant}\nBerat Ikan: {$weight} kg\nStatus Ikan: {$status} 🐟\n\n";
        }

        // Kirim pesan yang berisi hasil dari semua partisipan kepada pengguna
        $this->sendWhatsAppMessage($eventMessage, $userRecipientNumber);

        // Redirect dengan pesan sukses
        return redirect()->route('resultop.index', ['event' => $event->id])->with('success', 'Data berhasil disimpan. Notifikasi WhatsApp terkirim.');
    }

    // Method untuk mengirim pesan WhatsApp
    private function sendWhatsAppMessage($message, $recipientNumber)
    {
        $setting = Setting::first();
        $apiKey = $setting->api_key;
        $sender = $setting->sender;
        $endpoint = $setting->endpoint;

        try {
            $response = Http::post($endpoint, [
                'api_key' => $apiKey,
                'sender' => $sender,
                'number' => $recipientNumber,
                'message' => $message,
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to send WhatsApp notification');
            }
        } catch (\Exception $e) {
            // Tangani jika gagal mengirim pesan WhatsApp
            // Anda bisa melakukan redirect atau tindakan lain di sini
        }
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
            'participant' => 'required|exists:events_registration,user_id', // Pastikan user_id ada di event_registrations
            'image_data' => 'nullable|string', // Validasi untuk data gambar (opsional)
        ]);

        // Jika ada data gambar baru, simpan gambar dan perbarui path di database
        if ($request->has('image_data')) {
            $imagePath = $this->saveImage($validated['image_data']);
        } else {
            // Jika tidak ada data gambar baru, gunakan path yang sudah ada di database
            $imagePath = $result->image_path;
        }

        // Perbarui data hasil
        $result->update([
            'weight' => $validated['weight'],
            'status' => $validated['status'],
            'participant' => $validated['participant'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('resultop.index', ['event' => $event->id])->with('success', 'Data berhasil diperbarui');
    }

    private function save($imageData)
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
                    $eventRegistration->update(['payment_status' => 'attended']);
                    Log::info('Payment status updated to "attended" for event registration ID: ' . $eventRegistrationId);

                    $boothNumber = $this->assignRandomBooth($eventRegistration->event_id);
                    $eventRegistration->update(['booth' => $boothNumber]);

                    return redirect()->route('spin.spin')
                        ->with('eventRegistration', $eventRegistration)
                        ->with('success', 'Status pembayaran diubah menjadi attended. Notifikasi WhatsApp berhasil dikirim.');
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

    public function assignRandomBooth($eventId)
    {
        $event = Event::find($eventId);
        $totalBooth = $event->total_booth;

        // Ambil nomor-nomor booth yang belum terisi
        $availableBooths = range(1, $totalBooth);
        $occupiedBooths = Event_Registration::where('event_id', $eventId)
            ->whereNotNull('booth')
            ->pluck('booth')
            ->toArray();

        $availableBooths = array_diff($availableBooths, $occupiedBooths);

        $randomBooth = null;
        if (!empty($availableBooths)) {
            $randomBoothIndex = array_rand($availableBooths);
            $randomBooth = $availableBooths[$randomBoothIndex];
        }

        return $randomBooth;
    }
}
