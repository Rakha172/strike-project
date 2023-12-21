<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Result;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WinnerController extends Controller
{
    public function sendWinnerMessage(Request $request, $eventId)
    {
        $event = Event::find($eventId);

        $qualification = $event?->qualification;

        if (!$event) {
            return ['success' => false];
        }

        if ($qualification == 'weight') {
            $topResults = Result::where('event_id', $event->id)
                ->select(DB::raw('SUM(weight) as total_weight, user_id'))
                ->groupBy('user_id')
                ->orderByDesc('total_weight')
                ->take(3)
                ->get();

            $topThreeMessage = "*{$event->name}*\n";
            $topThreeMessage .= "*{$event->event_date}*\n\n";
            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Berat Ikan*\n";
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
            foreach ($event->members as $participant) {
                $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }
        } elseif ($qualification == 'special') {
            $topResults = Result::where('event_id', $event->id)
                ->select(DB::raw('COUNT(*) as total_special, user_id'))
                ->groupBy('user_id')
                ->orderByDesc('total_special')
                ->take(3)
                ->get();

            $topThreeMessage = "*{$event->name}*\n";
            $topThreeMessage .= "*{$event->event_date}*\n\n";
            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Ikan Special*\n";
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
            foreach ($event->members as $participant) {
                $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }
        } elseif ($qualification == 'quantity') {
            $topResults = Result::where('event_id', $event->id)
                ->select(DB::raw('COUNT(*) as total_quantity, user_id'))
                ->groupBy('user_id')
                ->orderByDesc('total_quantity')
                ->take(3)
                ->get();

            $topThreeMessage = "*{$event->name}*\n";
            $topThreeMessage .= "*{$event->event_date}*\n\n";
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
            foreach ($event->members as $participant) {
                $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }
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

            $topThreeMessage = "*{$event->name}*\n";
            $topThreeMessage .= "*{$event->event_date}*\n\n";
            $topThreeMessage .= "\n*Tiga Terbesar Berdasarkan Berat Ikan*\n";
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
            }

            // Mendapatkan informasi waktu dari pengguna
            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            //saran dari kang fahri
            // Mengirim pesan ke nomor WhatsApp masing-masing peserta
            foreach ($event->members as $participant) {
                $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }
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

            $topThreeMessage = "*{$event->name}*\n";
            $topThreeMessage .= "*{$event->event_date}*\n\n";
            $topThreeMessage .= "\n*Tiga Terbesar Berdasarkan Berat Ikan*\n";
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

            $topThreeMessage .= "*Tiga Terbesar Berdasarkan Ikan Special* \n";
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
            foreach ($event->members as $participant) {
                $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }
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

            $topThreeMessage = "*{$event->name}*\n";
            $topThreeMessage .= "*{$event->event_date}*\n\n";
            $topThreeMessage .= "\n*Tiga Terbesar Berdasarkan Berat Ikan*\n";
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
            }

            // Mendapatkan informasi waktu dari pengguna
            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            // Mengirim pesan ke nomor WhatsApp masing-masing peserta
            foreach ($event->members as $participant) {
                $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }
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

            $topThreeMessage = "*{$event->name}*\n";
            $topThreeMessage .= "*{$event->event_date}*\n\n";
            $topThreeMessage .= "\n*Tiga Terbesar Berdasarkan Jumlah Ikan*\n";
            foreach ($topResultsQuantity as $key => $totalCombined) {
                $participant = User::find($totalCombined->user_id);
                $quantity = $totalCombined->total_quantity;
                $position = $key + 1;

                $topThreeMessage .= "Posisi {$position}. {$participant->name} berhasil dengan jumlah ikan : {$quantity}\n";
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

            $userCreatedAt = $participant->created_at->format('Y-m-d H:i:s');
            $userUpdatedAt = $participant->updated_at->format('Y-m-d H:i:s');

            $topThreeMessage .= "\nWaktu pembuatan: {$userCreatedAt}\n";
            $topThreeMessage .= "Waktu perubahan terakhir: {$userUpdatedAt}\n";

            foreach ($topResultsQuantity as $topResult) {
                $participant = User::find($topResult->user_id);
                $this->sendWhatsAppMessage($topThreeMessage, $participant->phone_number);
            }
        }

        return ['success' => true]; // atau ['success' => false] jika gagal
    }

    private function sendWhatsAppMessage($message, $recipientNumber)
    {
        $setting = Setting::first();
        $apiKey = $setting->api_key;
        $sender = $setting->sender;
        $textEndpoint = $setting->endpoint; // Menggunakan endpoint untuk pesan teks saja, bukan media

        try {
            // Kirim pesan teks
            $responseText = Http::post($textEndpoint, [
                'api_key' => $apiKey,
                'sender' => $sender,
                'number' => $recipientNumber,
                'message' => $message,
            ]);

            if (!$responseText->successful()) {
                throw new \Exception('Failed to send WhatsApp text message');
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika diperlukan
            // Misalnya: log pesan kesalahan atau tindakan lain yang sesuai
            // echo $e->getMessage(); // Untuk menampilkan pesan kesalahan
        }
    }

}

