<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event_Registration;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        // dd($eventStatusPayed);

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

            $message = "Halo, {$user->name}! 🎉 Pembayaran untuk acara '{$event->name}' Anda telah dikonfirmasi oleh admin. Terima kasih banyak! 🙌";
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
}
