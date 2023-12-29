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
    public function index(Request $request)
    {
        $title = Setting::firstOrFail();
        $page = 5;
        $keyword = $request->keyword;
        $eventStatusPayed = Event_Registration::query()
            ->when($keyword, function (Builder $query, $keyword) {
                $query->whereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('name', 'like', "%$keyword%")
                        ->orWhere('event_date', 'like', "%$keyword%");
                });
            })
            ->where('payment_status', 'waiting')
            ->latest()
            ->paginate($page);

        return view('payment.payment-confirm-admin', compact('eventStatusPayed', 'title'));
    }

    public function update(Request $request, Event_Registration $event_registrationId)
    {
        try {
            $event_registrationId->update([
                'payment_status' => 'payed'
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
        $event_regist = Event_Registration::findOrFail($event_register_id);
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

        return redirect()->route('paymentConfirm', $event_register_id->id)->with('berhasil', "Berhasil diubah");
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

        // Waktu target (30 menit dari waktu updated_at)
        $targetTime = $event_regist->updated_at->addMinutes(10);

        // Waktu sekarang
        $now = Carbon::now();
        // Hitung selisih waktu dalam menit dan detik
        $diff = $now->diff($targetTime);
        $countdown = [
            'minutes' => $diff->format('%i'),
            'seconds' => $diff->format('%s'),
        ];

        // Jika countdown sudah habis, perbarui status menjadi "cancel"
        if ($diff->invert == 1) {
            // Countdown sudah habis
            $event_regist->payment_status = 'cancel';
            $event_regist->save();
        }

        $event_name = $event_regist->event->name;
        $price = $event_regist->event->price;
        $date = $event_regist->event->event_date;
        $name = $event_regist->paymentTypes->name;
        $account = $event_regist->paymentTypes->account_number;
        $owner = $event_regist->paymentTypes->owner;


        try {
            $setting = Setting::first();
            $message = "Halo, {$userName}!🌟\n\n";
            $message .= "Selamat! Anda telah terdaftar untuk acara '{$event_name}'
                         yang akan diselenggarakan pada 🗓️ {$date}\n\n";
            $message .= "Total biaya pendaftaran : Rp " . number_format($price, 0, '.', '.') . "\n\n";
            $message .= "Silakan lakukan pembayaran ke {$name} kami :\n\n";
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

        // Pesan untuk admin
        try {
            $adminNumber = '08872354643'; // Nomor WhatsApp admin

            $setting = Setting::first();
            $messageAdmin = "Halo Admin! 🌟\n\n";
            $messageAdmin .= "Mohon konfirmasi pembayaran untuk pengguna berikut yang akan mengikuti acara :\n\n";
            $messageAdmin .= "Nama Pengguna : {$userName}\n";
            $messageAdmin .= "Acara yang Diikuti : '{$event_regist->event->name}'\n\n";
            $messageAdmin .= "Terima kasih! 🎉";

            $apiKey = $setting->api_key;
            $sender = $setting->sender;
            $endpoint = $setting->endpoint;

            $response = Http::post($endpoint, [
                'api_key' => $apiKey,
                'sender' => $sender,
                'number' => $adminNumber, // Nomor WhatsApp admin
                'message' => $messageAdmin,
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to send WhatsApp notification to admin');
            }
        } catch (\Exception $e) {
            return redirect()->route('payment')->with('error', 'Gagal mengirim notifikasi WhatsApp ke admin: ' . $e->getMessage());
        }

        return view('payment.payment-confirm-member', compact('event_regist', 'users', 'userName', 'title', 'paymentTypes', 'countdown'));
    }


    // public function expiredOrder(Request $request, $event_regist_id)
    // {
    //     $event_regist_id = decrypt($event_regist_id);
    //     $eventData = Event_Registration::findOrFail($event_regist_id->event_id);
    //     $eventData->update([
    //         'status' => 'cancel',
    //     ]);

    //     return redirect()->route('payment-confirm', $event_regist_id);
    // }
    // Contoh di Controller

    public function processData(Request $request)
    {
        try {
            // Terima semua data dari Moota
            $mootaData = $request->all();

            // Langsung proses semua data
            foreach ($mootaData as $data) {
                $price = intval($data['amount']);

                Event_Registration::where([
                    'event_id' => function ($query) use ($price) {
                        $query->select('id')->from('events')->where('price', $price);
                    },
                    'payment_status' => 'waiting',
                ])->update(['payment_status' => 'payed']);
            }

            return response()->json(['message' => 'Data processed successfully'], 200);
        } catch (\Exception $e) {
            // Tangkap dan log kesalahan jika terjadi
            return response()->json(['error' => 'Error during data processing: ' . $e->getMessage()], 500);
        }
    }

}

