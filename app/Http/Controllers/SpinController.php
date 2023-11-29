<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class SpinController extends Controller
{
    public function spin()
    {
        // Mendapatkan angka-angka dari controller (gantilah dengan logika atau data sebenarnya)
        $numbers = range(1, 10);

        // Dapatkan data acara dengan nilai "both" acak
        $events = Event::inRandomOrder()->get();

        // Kirimkan data acara dan angka-angka ke tampilan "spin"
        return view('spin.spin', compact('events', 'numbers'));
    }

    public function showForm()
    {
        return view('spin.spin-rafly');
    }

    public function processForm(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
        ]);

        // Tampilkan hasil
        return view('spin.spin-rafly', ['result' => $validated]);
    }

    public function updatePreview(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
        ]);

        return response()->json(['result' => $validated]);
    }

}
