<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = Setting::firstOrFail();
        $user = User::all();
        return view('user.index', compact('user', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = Setting::firstOrFail();
        return view('user.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        User::create($validated);

        return redirect()->route('user.index')->with('berhasil', "$request->name Berhasil ditambahkan");
    }
    public function edit(User $user)
    {
        $title = Setting::firstOrFail();
        return view('user.edit', compact('user', 'title'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'phone_number' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'nullable',
        ]);

        $user->update($validated);

        return redirect()->route('user.index')->with('berhasil', "$request->name Berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('berhasil', "$user->name Berhasil dihapus");
    }

    public function updateprofile(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $user->update($validated);

        if ($user) {
            return redirect()->route('events')->with('success', "Changed Successfully");
        }else{
            return back();
        }

    }
}
