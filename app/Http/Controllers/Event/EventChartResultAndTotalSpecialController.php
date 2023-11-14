<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventChartResultAndTotalSpecialController extends Controller
{
    public function __invoke(Request $request, Event $event)
    {
        $dataTotalIkan = $event->members->map(function ($member) use ($event) {
            return [
                'label' => $member->name,
                'data' => $event->results()->where('user_id', $member->id)->sum('status'),
            ];
        });

        $dataIkanSpecial = $event->members->map(function ($member) use ($event) {
            return [
                'label' => $member->name,
                'data' => $event->results()
                    ->where('user_id', $member->id)
                    ->where('status', 'special')
                    ->count(),
            ];
        });

        $labels = $dataTotalIkan->pluck('label')->toArray();
        $dataTotalIkan = $dataTotalIkan->pluck('data')->toArray();
        $dataIkanSpecial = $dataIkanSpecial->pluck('data')->toArray();

        return view('event.chart-result-and-total-special', compact('labels', 'dataTotalIkan', 'dataIkanSpecial', 'event'));
    }
}
