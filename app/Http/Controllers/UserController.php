<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $title = Setting::firstOrFail();
        $user = User::all();
        return view('user.index', compact('user', 'title'));
    }

    public function create()
    {
        $title = Setting::firstOrFail();
        return view('user.create', compact('title'));
    }

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

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('berhasil', "$user->name Berhasil dihapus");
    }

    public function updateprofile(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'phone_number' => 'required|unique:users|numeric|digits:12',
        ]);

        $user->update($validated);

        if ($user) {
            return redirect()->route('events')->with('success', "Changed Successfully");
        } else {
            return back();
        }

    }
}
