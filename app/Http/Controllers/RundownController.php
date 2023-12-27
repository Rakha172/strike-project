<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class RundownController extends Controller
{
    public function index(Request $request, $eventId, $eventRegistrationId)
    {
        try {
            $event = Event::findOrFail($eventId);

            $eventRegistration = $event->event_regist()->findOrFail($eventRegistrationId);

            // Jika booth belum terisi, maka generate nomor booth acak
            if (!$eventRegistration->booth) {
                $boothAvailable = $this->getAvailableBooths($event);
                $randomBooth = $this->generateRandomBooth($boothAvailable);

                // Update booth pada event registration
                $eventRegistration->update(['booth' => $randomBooth]);
            }

            // Menambahkan $boothAvailable ke dalam array data yang dikirimkan ke view
            return view('operator.rundown', [
                'event' => $event,
                'eventRegistration' => $eventRegistration,
                'boothAvailable' => $this->getAvailableBooths($event), // Tambahkan baris ini
            ]);
        } catch (\Exception $e) {
            return response()->view('errors.404', [], 404);
        }
    }


    // Fungsi untuk mendapatkan booth yang masih tersedia
    private function getAvailableBooths(Event $event)
    {
        $boothExists = $event->event_regist()->whereNotNull('booth')->pluck('booth');

        $boothAvailable = [];

        for ($i = 1; $i <= $event->total_booth; $i++) {
            if (!in_array($i, $boothExists->toArray())) {
                $boothAvailable[] = $i;
            }
        }

        return $boothAvailable;
    }

    // Fungsi untuk menghasilkan nomor booth acak
    private function generateRandomBooth(array $boothAvailable)
    {
        $randomIndex = array_rand($boothAvailable);

        return $boothAvailable[$randomIndex];
    }
}
