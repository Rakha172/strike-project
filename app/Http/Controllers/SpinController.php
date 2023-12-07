<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class SpinController extends Controller
{
    public function spin(Event $events)
    {
        // Mendapatkan angka-angka dari controller (gantilah dengan logika atau data sebenarnya)
        $numbers = range(1, 10);

        // Dapatkan data acara dengan nilai "both" acak
        $events = Event::inRandomOrder()->get();

        // Kirimkan data acara dan angka-angka ke tampilan "spin"
        return view('spin.spin', compact('events', 'numbers'));
    }

    public function getTotalBooth($eventId)
    {
        $event = Event::find($eventId);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $totalBooth = $event->total_booth;

        return response()->json(['total_booth' => $totalBooth]);
    }

}
