<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Result;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Event_Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Log; // Pastikan ini di atas kelas Controller

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

        // Dapatkan nilai qualification dari event yang diberikan
        // $qualification = $event->qualification; // Pastikan attribute sesuai dengan struktur tabel
        $qualification = $event->qualification; // Pastikan attribute sesuai dengan struktur tabel

        if ($qualification == 'weight') {
            $topResults = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight, user_id'))
                ->groupBy('user_id')
                ->orderByDesc('total_weight')
                ->take(3)
                ->get();

            $topThreeMessage = str_pad('', 50, ' ') . "{$event->name}\n";
            $topThreeMessage .= str_pad('', 50, ' ') . "{$event->event_date}\n\n";
            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Jumlah Ikan*\n";
            foreach ($topResults as $key => $totalWeight) {
                $participant = User::find($totalWeight->user_id);
                $weight = $totalWeight->total_weight;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} dengan total berat ikan {$weight} gram\n";
            }

            // Mendapatkan informasi waktu dari pengguna
            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            // Mengirim pesan ke nomor WhatsApp masing-masing peserta
            foreach ($topResults as $topResult) {
                $participant = User::find($topResult->user_id);
            }

            $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
        } elseif ($qualification == 'special') {
            $topResults = Result::where('event_id', $event->id)
                ->select(DB::raw('COUNT(*) as total_special, user_id'))
                ->groupBy('user_id')
                ->orderByDesc('total_special')
                ->take(3)
                ->get();

            $topThreeMessage = str_pad('', 50, ' ') . "{$event->name}\n";
            $topThreeMessage .= str_pad('', 50, ' ') . "{$event->event_date}\n\n";
            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Jumlah Ikan*\n";
            foreach ($topResults as $key => $totalSpecial) {
                $participant = User::find($totalSpecial->user_id);
                $special = $totalSpecial->total_special;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} dengan total Ikan Special : {$special}";
            }

            // Mendapatkan informasi waktu dari pengguna
            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            // Mengirim pesan ke nomor WhatsApp masing-masing peserta
            foreach ($topResults as $topResult) {
                $participant = User::find($topResult->user_id);
            }

            $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
        } elseif ($qualification == 'quantity') {
            $topResults = Result::where('event_id', $event->id)
                ->select(DB::raw('COUNT(*) as total_quantity, user_id'))
                ->groupBy('user_id')
                ->orderByDesc('total_quantity')
                ->take(3)
                ->get();

            $topThreeMessage = str_pad('', 50, ' ') . "{$event->name}\n";
            $topThreeMessage .= str_pad('', 50, ' ') . "{$event->event_date}\n\n";
            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Jumlah Ikan*\n";
            foreach ($topResults as $key => $totalQuantity) {
                $participant = User::find($totalQuantity->user_id);
                $quantity = $totalQuantity->total_quantity;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} dengan Jumlah Ikan : {$quantity}\n";
            }

            // Mendapatkan informasi waktu dari pengguna
            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            // Mengirim pesan ke nomor WhatsApp masing-masing peserta
            foreach ($topResults as $topResult) {
                $participant = User::find($topResult->user_id);
            }

            $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
        } elseif ($qualification == 'combined') {
            $topResults = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight,
                    SUM(CASE WHEN status = "special" THEN 1 ELSE 0 END) as total_special,
                    COUNT(CASE WHEN status = "regular" THEN 1 ELSE 0 END) as total_quantity,
                    user_id'))
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('total_weight')) // Urutkan berdasarkan total berat ikan
                ->take(3)
                ->get();

            $topThreeMessage = str_pad('', 50, ' ') . "{$event->name}\n";
            $topThreeMessage .= str_pad('', 50, ' ') . "{$event->event_date}\n\n";
            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Jumlah Ikan*\n";
            foreach ($topResults as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $weight = $totalCombined->total_weight;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan total berat ikan : {$weight} gram\n";
            }

            // Kategori berdasarkan ikan special
            $topResultsSpecial = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight,
                SUM(CASE WHEN status = "special" THEN 1 ELSE 0 END) as total_special,
                COUNT(CASE WHEN status = "regular" THEN 1 ELSE 0 END) as total_quantity,
                user_id'))
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('total_special')) // Urutkan berdasarkan jumlah ikan spesial
                ->take(3)
                ->get();

            $topThreeMessage .= "\n*Tiga Terbesar Berdasarkan Ikan Special* \n";
            foreach ($topResultsSpecial as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $special = $totalCombined->total_special;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan jumlah ikan special : {$special}\n";
            }

            // Kategori berdasarkan jumlah ikan
            $topResultsSpecial = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight,
             SUM(CASE WHEN status = "special" THEN 1 ELSE 0 END) as total_special,
             COUNT(CASE WHEN status = "regular" THEN 1 ELSE 0 END) as total_quantity,
             user_id'))
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('total_quantity')) // Urutkan berdasarkan jumlah ikan
                ->take(3)
                ->get();

            $topThreeMessage .= "\n*Tiga Terbesar Berdasarkan Jumlah Ikan* \n";
            foreach ($topResultsSpecial as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $quantity = $totalCombined->total_quantity;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan jumlah ikan : {$quantity}\n";
                // $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }

            // Mendapatkan informasi waktu dari pengguna
            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            // Mengirim pesan ke nomor WhatsApp masing-masing peserta
            foreach ($topResults as $topResult) {
                $participant = User::find($topResult->user_id);
            }

            $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
        } elseif ($qualification == 'weight_special') {
            $topResults = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight,
                SUM(CASE WHEN status = "special" THEN 1 ELSE 0 END) as total_special,
                COUNT(CASE WHEN status = "regular" THEN 1 ELSE 0 END) as total_quantity,
                user_id'))
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('total_weight')) // Urutkan berdasarkan total berat ikan
                ->take(3)
                ->get();

            $topThreeMessage = str_pad('', 50, ' ') . "{$event->name}\n";
            $topThreeMessage .= str_pad('', 50, ' ') . "{$event->event_date}\n\n";
            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Jumlah Ikan*\n";
            foreach ($topResults as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $weight = $totalCombined->total_weight;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan total berat ikan : {$weight} gram\n";
            }

            // Kategori berdasarkan ikan special
            $topResultsSpecial = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight,
                SUM(CASE WHEN status = "special" THEN 1 ELSE 0 END) as total_special,
                COUNT(CASE WHEN status = "regular" THEN 1 ELSE 0 END) as total_quantity,
                user_id'))
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('total_special')) // Urutkan berdasarkan jumlah ikan spesial
                ->take(3)
                ->get();

            $topThreeMessage .= "\n*Tiga Terbesar Berdasarkan Ikan Special* \n";
            foreach ($topResultsSpecial as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $special = $totalCombined->total_special;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan jumlah ikan special : {$special}\n";
                // $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }

            // Mendapatkan informasi waktu dari pengguna
            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            // Mengirim pesan ke nomor WhatsApp masing-masing peserta
            foreach ($topResults as $topResult) {
                $participant = User::find($topResult->user_id);
            }

            $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
        } elseif ($qualification == 'weight_quantity') {
            $topResults = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight,
                SUM(CASE WHEN status = "special" THEN 1 ELSE 0 END) as total_special,
                COUNT(CASE WHEN status = "regular" THEN 1 ELSE 0 END) as total_quantity,
                user_id'))
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('total_weight')) // Urutkan berdasarkan total berat ikan
                ->take(3)
                ->get();

            $topThreeMessage = str_pad('', 50, ' ') . "{$event->name}\n";
            $topThreeMessage .= str_pad('', 50, ' ') . "{$event->event_date}\n\n";
            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Jumlah Ikan*\n";
            foreach ($topResults as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $weight = $totalCombined->total_weight;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan total berat ikan : {$weight} gram\n";
            }

            // Kategori berdasarkan jumlah ikan
            $topResultsSpecial = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight,
                SUM(CASE WHEN status = "special" THEN 1 ELSE 0 END) as total_special,
                COUNT(CASE WHEN status = "regular" THEN 1 ELSE 0 END) as total_quantity,
                user_id'))
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('total_quantity')) // Urutkan berdasarkan jumlah ikan
                ->take(3)
                ->get();

            $topThreeMessage .= "\n*Tiga Terbesar Berdasarkan Jumlah Ikan* \n";
            foreach ($topResultsSpecial as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $quantity = $totalCombined->total_quantity;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan jumlah ikan : {$quantity}\n";
                // $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }

            // Mendapatkan informasi waktu dari pengguna
            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            // Mengirim pesan ke nomor WhatsApp masing-masing peserta
            foreach ($topResults as $topResult) {
                $participant = User::find($topResult->user_id);
            }

            $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
        } elseif ($qualification == 'quantity_special') {
            $topResultsQuantity = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight,
                    SUM(CASE WHEN status = "special" THEN 1 ELSE 0 END) as total_special,
                    COUNT(CASE WHEN status = "regular" THEN 1 ELSE 0 END) as total_quantity,
                    user_id'))
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('total_quantity'))
                ->take(3)
                ->get();

            $topThreeMessage = str_pad('', 50, ' ') . "{$event->name}\n";
            $topThreeMessage .= str_pad('', 50, ' ') . "{$event->event_date}\n\n";
            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Jumlah Ikan*\n";
            foreach ($topResultsQuantity as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $quantity = $totalCombined->total_quantity;
                $position = $key + 1;

                // $topThreeMessage .= "Event {$event->name}";
                // $topThreeMessage .= "Pada Tanggal {$event->event_date}";
                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan jumlah ikan : {$quantity}\n";

                // // Mendapatkan informasi waktu dari pengguna
                // $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
                // $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

                // $topThreeMessage .= "  - Waktu pembuatan: {$userCreatedAt}\n";
                // $topThreeMessage .= "  - Waktu perubahan terakhir: {$userUpdatedAt}\n";
            }

            // Kategori berdasarkan ikan special
            $topResultsSpecial = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight,
                    SUM(CASE WHEN status = "special" THEN 1 ELSE 0 END) as total_special,
                    COUNT(CASE WHEN status = "regular" THEN 1 ELSE 0 END) as total_quantity,
                    user_id'))
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('total_special'))
                ->take(3)
                ->get();

            $topThreeMessage .= "\n*Tiga Terbesar Berdasarkan Ikan Special*\n";
            foreach ($topResultsSpecial as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $special = $totalCombined->total_special;
                $position = $key + 1;


                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan jumlah ikan special : {$special}\n";
            }

            // Mendapatkan informasi waktu dari pengguna
            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            // Mengirim pesan ke nomor WhatsApp masing-masing peserta
            foreach ($topResultsQuantity as $topResult) {
                $participant = User::find($topResult->user_id);
                $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }
        }

        $userTotalCatch = Result::where([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ])->count();

        // Pesan untuk pengguna berdasarkan input mereka
        $userMessage = "Halo, {$user->name}! 🎉\n\n";
        $userMessage .= "Berikut adalah detail laporan ikan ke-{$userTotalCatch} Anda :\n\n";
        $userMessage .= "Berat Ikan : {$result->weight} gram\n";
        $userMessage .= "Status Ikan : {$result->status} 🐟🌟";

        // Mendapatkan informasi waktu dari pengguna
        $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
        $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

        $userMessage .= "\n\nWaktu pembuatan: {$userCreatedAt}\n";
        $userMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}";

        $userRecipientNumber = $user->phone_number;

        // Mengirim pesan hanya kepada pengguna yang baru terdaftar
        $this->sendWhatsAppMessage($userMessage, $userRecipientNumber);

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

                    // Fungsi untuk menentukan total booth
                    $boothNumber = $this->assignRandomBooth($eventRegistration->event_id);
                    $eventRegistration->update(['booth' => $boothNumber]);

                    // Kirim notifikasi WhatsApp ke pengguna terkait
                    $user = $eventRegistration->user; // Sesuaikan dengan relasi yang ada pada model Event_Registration
                    $event = $eventRegistration->event; // Sesuaikan dengan relasi yang ada pada model Event

                    $setting = Setting::first();
                    $apiKey = $setting->api_key;
                    $sender = $setting->sender;
                    $endpoint = $setting->endpoint;

                    $message = "Halo, {$user->name}!🎉\n\n";
                    $message .= "Terima kasih telah menghadiri acara '{$event->name}'\n\n";
                    $message .= "Kami sangat mengapresiasi partisipasimu! semoga acaranya menyenangkan dan bermanfaat untukmu🌟";
                    $recipientNumber = $user->phone_number;

                    $response = Http::post($endpoint, [
                        'api_key' => $apiKey,
                        'sender' => $sender,
                        'number' => $recipientNumber,
                        'message' => $message,
                    ]);

                    if ($response->successful()) {
                        return redirect()->route('spin.spin')
                            ->with('eventRegistration', $eventRegistration)
                            ->with('success', 'Status pembayaran diubah menjadi attended. Notifikasi WhatsApp berhasil dikirim.');
                    } else {
                        throw new \Exception('Failed to send WhatsApp notification');
                    }
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
