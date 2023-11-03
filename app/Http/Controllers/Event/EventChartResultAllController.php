<?php

namespace App\Http\Controllers\Event;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventChartResultAllController extends Controller
{
    public function __invoke(Request $request, Event $event)
    {
        $dataWeightTotal = $event->members->map(function ($member) use ($event) {
            return [
                'label' => $member->name,
                'data' => $event->results()->where('user_id', $member->id)->sum('weight'),
            ];
        });

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

        $labels = $dataWeightTotal->pluck('label')->toArray();
        $dataWeightTotal = $dataWeightTotal->pluck('data')->toArray();
        $dataTotalIkan = $dataTotalIkan->pluck('data')->toArray();
        $dataIkanSpecial = $dataIkanSpecial->pluck('data')->toArray();

        return view('event.chart-combined', compact('labels', 'dataWeightTotal', 'dataTotalIkan', 'dataIkanSpecial', 'event'));
    }
}
