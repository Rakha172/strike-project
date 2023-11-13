<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class SpinController extends Controller
{
    public function spin()
    {
        // Dapatkan data acara dengan nilai "both" acak
        $events = Event::inRandomOrder()->get();

        $no = range(1, 10);
        // Kirimkan data acara ke tampilan "spin"
        return view('spin.spin', compact('events','no'));
    }

}
