<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventChartResultAndTotalController extends Controller
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

        $labels = $dataWeightTotal->pluck('label')->toArray();
        $dataWeightTotal = $dataWeightTotal->pluck('data')->toArray();
        $dataTotalIkan = $dataTotalIkan->pluck('data')->toArray();

        return view('event.chart-result-and-total', compact('labels', 'dataWeightTotal', 'dataTotalIkan', 'event'));
    }
}
