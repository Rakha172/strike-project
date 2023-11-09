<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpinController extends Controller
{
    public function index()
    {
        $events = range(1, 10); // Membuat array dari 1 hingga 10
        return view('spin.spin', compact('events'));
    }

}
