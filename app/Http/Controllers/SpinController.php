<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class SpinController extends Controller
{
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
