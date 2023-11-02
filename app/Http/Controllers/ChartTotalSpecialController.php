<?php

namespace App\Http\Controllers;


use App\Models\Setting;
use App\Models\Result;
use Illuminate\Http\Request;

class ChartTotalSpecialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = Setting::firstOrFail();
        $results = Result::where('status', 'special')->get();
        $labels = $results->map(function ($result) {
            return $result->user->name;
        });

        $fish_totals = $results->pluck('fish_total');

        return view('chart-total-special.index', compact('labels', 'fish_totals', 'title'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
