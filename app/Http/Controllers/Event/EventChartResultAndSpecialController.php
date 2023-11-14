<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventChartResultAndSpecialController extends Controller
{
    public function __invoke(Request $request, Event $event)
    {
        $dataWeightTotal = $event->members->map(function ($member) use ($event) {
            return [
                'label' => $member->name,
                'data' => $event->results()->where('user_id', $member->id)->sum('weight'),
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
        $dataIkanSpecial = $dataIkanSpecial->pluck('data')->toArray();

        return view('event.chart-result-and-special', compact('labels', 'dataWeightTotal', 'dataIkanSpecial', 'event'));
    }
}
