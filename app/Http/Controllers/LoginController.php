<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:web', ['except' => 'logout']);
    }

    public function login()
    {
        $title = Setting::firstOrFail();
        return view('login.login', compact('title'));
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email berupa email.',
            'password.required' => 'Password wajib diisi',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard')->with('success', 'Anda Berhasil Login!');
            } else if (Auth::user()->role == 'member') {
                return redirect('/event')->with(['success' => $request->name . "Selamat Datang"]);
            } else if (Auth::user()->role == 'operator') {
                return redirect('/eventsop')->with(['success' => $request->name . "Berhasil Login"]);
            }
        }

        return back()->withErrors([
            'email' => 'Kredentials yang diinputkan tidak cocok',
        ]);
    }

    public function logout()
    {
         Auth::logout();
    return redirect('/login')->with('status', 'Anda berhasil logout.');
    }
}

