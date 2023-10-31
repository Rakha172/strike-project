<?php

namespace App\Http\Controllers;

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
        return view('login.login');
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
                return redirect('/dashboard')->with('success', 'Anda berhasil login!');
            } else if (Auth::user()->role == 'member') {
                return redirect('/event')->with(['success' => $request->name . "Berhasil Login"]);
            } else if (Auth::user()->role == 'operator') {
                return redirect('/result')->with(['success' => $request->name . "Berhasil Login"]);

            }
        }

        return back()->withErrors([
            'email' => 'Kredentials yang diinputkan tidak cocok',
        ]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return to_route('login');
    }
}

