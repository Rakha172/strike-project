<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Setting;
use App\Models\PaymentTypes;
use Illuminate\Http\Request;
use App\Models\Event_Registration;
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

        if(auth()->check()) {
            $user = auth()->user();
            $userName = $user->name;
            // $event_regist = $user->event_regist->price;
            $event_regist = Event_Registration::findOrFail($event_register_id);
        }

        return view('payment.payment-member', compact('event_regist', 'users', 'userName', 'title'));
    }
}
