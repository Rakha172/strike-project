<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'email' => 'required|string|email|max:255',

        ], [
            'name.required' => 'Username wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email berupa email.',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_confirmation' => 'Konfirmasi password tidak cocok',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Sesuaikan dengan logika pengiriman email verifikasi jika diperlukan

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan masuk.');
    }
}

