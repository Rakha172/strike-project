<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Setting;
use App\Models\PaymentTypes;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event_Registration;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder;

class PaymentController extends Controller
{
    public function update(Request $request, Event_Registration $event_registrationId)
    {
        try {
            $event_registrationId->update([
                'payment_status' => 'paid'
            ]);

            // Kirim notifikasi WhatsApp kepada pengguna terkait
            $user = $event_registrationId->user; // Sesuaikan dengan relasi yang ada pada model Event_Registration
            $event = $event_registrationId->event; // Sesuaikan dengan relasi yang ada pada model Event

            $setting = Setting::first();
            $apiKey = $setting->api_key;
            $sender = $setting->sender;
            $endpoint = $setting->endpoint;

            $message = "Halo, {$user->name}!\n\n";
            $message .= "Pembayaran untuk acara '{$event->name}' Anda telah dikonfirmasi oleh admin\n\n";
            $message .= "Terima kasih banyak! 🙌";
            $recipientNumber = $user->phone_number;

            $response = Http::post($endpoint, [
                'api_key' => $apiKey,
                'sender' => $sender,
                'number' => $recipientNumber,
                'message' => $message,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Pesanan dengan ID ' . $event_registrationId->id . ' atas nama ' . $user->name . ' berhasil dikonfirmasi. Notifikasi WhatsApp berhasil dikirim.');
            } else {
                throw new \Exception('Failed to send WhatsApp notification');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function member(Request $Request, $event_register_id)
    {
        $title = Setting::firstOrFail();
        // $event_regist = Event_Registration::all();
        $users = User::all();

        if (auth()->check()) {
            $user = auth()->user();
            $userName = $user->name;
            $event_regist = Event_Registration::findOrFail($event_register_id);
            $paymentTypes = PaymentTypes::all();
        }
        return view('payment.payment-member', compact('event_regist', 'users', 'userName', 'title', 'paymentTypes'));
    }

    public function updatePayment(Request $request, Event_Registration $event_register_id)
    {
        $validated = $request->validate([
            'payment_types_id' => 'required',
        ]);

        $event_register_id->update($validated);

        return redirect()->route('paymentConfirm', $event_register_id->id)->with('berhasil', "Berhasil");
    }

      public function processData(Request $request)
    {
        try {
            // Terima semua data dari Moota
            $mootaData = $request->all();

            // Langsung proses semua data
            foreach ($mootaData as $data) {
                $price = intval($data['amount']);

                $eventRegistration = Event_Registration::query()->where('payment_total', intval($data['amount']))
                    ->where('payment_status', 'waiting')
                    ->where('regist_date', Carbon::parse($data['date'])->format('Y-m-d'))
                    ->get();
                Log::info($eventRegistration);
                foreach ($eventRegistration as $item) {
                    if ($item) {
                        $eventRegistData = Event_Registration::findOrFail($item->id);
                        $eventRegistData->update(['payment_status' => 'paid']);
                    }
                }
            }

            return response()->json(['message' => 'Data processed successfully'], 200);
        } catch (\Exception $e) {

            Log::error('Error during data processing: ' . $e->getMessage());
            return response()->json(['error' => 'Error during data processing: ' . $e->getMessage()], 500);
        }
    }

    public function paymentConfirm(Request $request, $event_register_id)
    {
        $title = Setting::firstOrFail();
        $users = User::all();

        if (auth()->check()) {
            $user = auth()->user();
            $userName = $user->name;
            $paymentTypes = PaymentTypes::all();
            $event_regist = Event_Registration::find($event_register_id);
        }

        $targetTime = $event_regist->updated_at->addMinutes(1);

        // Waktu sekarang
        $now = Carbon::now();
        // Hitung selisih waktu dalam menit dan detik
        $diff = $now->diff($targetTime);
        $countdown = [
            'minutes' => $diff->format('%i'),
            'seconds' => $diff->format('%s'),
        ];

        $event_name = $event_regist->event->name;
        $price = $event_regist->payment_total;
        $date = $event_regist->event->event_date;
        $name = $event_regist->paymentTypes->name;
        $account = $event_regist->paymentTypes->account_number;
        $owner = $event_regist->paymentTypes->owner;

        if ($event_regist->payment_status == 'waiting') {
            try {
                $setting = Setting::first();
                $message = "Selamat! {$userName} kamu telah terdaftar untuk acara '{$event_name}' yang akan diselenggarakan pada 🗓️ {$date}\n\n";
                $message .= "Silakan lakukan pembayaran ke {$name} kami :\n\n";
                $message .= "Total biaya pendaftaran : Rp " . number_format($price, 0, '.', '.') . "\n";
                $message .= "Nomor {$name} : {$account} \n";
                $message .= "Atas Nama : {$owner}\n\n";
                $message .= "Mohon segera menyelesaikan pembayaran untuk menyelesaikan pendaftaran\n";
                $message .= "Terima kasih atas partisipasinya! 🎉";
                $recipientNumber = $user->phone_number;
                $apiKey = $setting->api_key;
                $sender = $setting->sender;
                $endpoint = $setting->endpoint;

                $response = Http::post($endpoint, [
                    'api_key' => $apiKey,
                    'sender' => $sender,
                    'number' => $recipientNumber,
                    'message' => $message,
                ]);

                if (!$response->successful()) {
                    throw new \Exception('Failed to send WhatsApp notification to user');
                }
            } catch (\Exception $e) {
                if (!$event_regist) {
                    return redirect()->route('paymentConfirm')->with('error', 'Event registration not found');
                }
            }
        }

        if ($event_regist->payment_status == 'paid') {
            try {
                $setting = Setting::first();
                $message = "Halo, {$userName}!🌟\n";
                $message .= "Pembayaran Anda Berhasil, Terimakasih😁😇";
                $recipientNumber = $user->phone_number;
                $apiKey = $setting->api_key;
                $sender = $setting->sender;
                $endpoint = $setting->endpoint;

                $response = Http::post($endpoint, [
                    'api_key' => $apiKey,
                    'sender' => $sender,
                    'number' => $recipientNumber,
                    'message' => $message,
                ]);

                return redirect()->route('events')->with('succes', 'Payment Succest');

                if (!$response->successful()) {
                    throw new \Exception('Failed to send WhatsApp notification to user');
                }
            } catch (\Exception $e) {
                if (!$event_regist) {
                    return redirect()->route('paymentConfirm')->with('error', 'Event registration not found');
                }
            }
        }

        return view('payment.payment-confirm-member', compact('event_regist', 'users', 'userName', 'title', 'paymentTypes', 'countdown'));
    }

}


