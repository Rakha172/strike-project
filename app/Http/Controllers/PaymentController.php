<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event_Registration;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
        $event_registrationId->update([
            'payment_status' => 'payed'
        ]);

        return back()->with('success', 'Pesanan dengan ID ' . $event_registrationId->id . ' atas nama ' . $event_registrationId->user->name . ' berhasil dikonfirmasi');
    }

    public function cancel(Request $request, Event_Registration $event_registrationId)
    {
        $event_registrationId->update([
            'payment_status' => 'cancel'
        ]);

        return back()->with('success', 'Pesanan dengan ID ' . $event_registrationId->id . ' atas nama ' . $event_registrationId->user->name . ' berhasil dibatalkan');
    }
}
