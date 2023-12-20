<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RundownController extends Controller
{
    public function index()
    {

        return view('operator.rundown');

    }
}
