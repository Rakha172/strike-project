<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class RundownController extends Controller
{
    public function index(Request $request, $eventId)
    {
        try {
            // Gunakan findOrFail untuk mendapatkan acara atau lempar pengecualian 404 jika tidak ditemukan
            $event = Event::findOrFail($eventId);

            $boothExists = $event->event_regist()->whereNotNull('booth')->pluck('booth');

            $boothAvailable = [];

            for ($i = 1; $i <= $event->total_booth; $i++) {
                if (!in_array($i, $boothExists->toArray())) {
                    $boothAvailable[] = $i;
                }
            }

            return view('operator.rundown', ['event' => $event, 'boothAvailable' => $boothAvailable]);
        } catch (\Exception $e) {
            // Tangani pengecualian (misalnya, tampilkan halaman 404)
            return response()->view('errors.404', [], 404);
        }
    }
}
