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

            if (!$eventRegistration->booth) {
                $boothAvailable = $this->getAvailableBooths($event);

            }

            return view('operator.rundown', [
                'event' => $event,
                'eventRegistration' => $eventRegistration,
                'boothAvailable' => $this->getAvailableBooths($event),
            ]);
        } catch (\Exception $e) {
            return response()->view('errors.404', [], 404);
        }
    }


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

    public function storeNumber(Request $request, $eventId, $eventRegistrationId)
    {
        try {
            $eventRegistration = Event::findOrFail($eventId)->event_regist()->findOrFail($eventRegistrationId);

            if (!$eventRegistration->booth) {
                $number = $request->input('number');

                $eventRegistration->update(['booth' => $number]);

                return response()->json(['success' => true, 'message' => 'Angka berhasil disimpan.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Booth sudah diisi sebelumnya.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.']);
        }
    }

}
