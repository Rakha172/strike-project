<?php

namespace App\Http\Controllers\Event;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventChartResultController extends Controller
{
    public function __invoke(Request $request, Event $event)
    {
        $data = $event->members->map(function ($member) use ($event) {
            return [
                'label' => $member->name,
                'data' => $event->results()->where('user_id', $member->id)->sum('weight'),
            ];
        });

        $data = collect($data)->sortByDesc('data');

        $labels = $data->pluck('label')->toArray();
        $data = $data->pluck('data')->toArray();

        return view('event.chart-result', compact('data', 'labels'));

    }
}
