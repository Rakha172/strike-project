<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
        $setting = Setting::first();
        $apiKey = $setting->api_key;
        $sender = $setting->sender;
        $endpoint = $setting->endpoint;

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
            } else if (Auth::user()->role == 'operator') {
                return redirect('/eventsop')->with(['succes' => $request->name . "Berhasil Login"]);
            } else if (Auth::user()->role == 'member') {
                $user = Auth::guard('web')->user();

                $recipientNumber = $user->phone_number;
                $message = "🎣 Hai {$user->name}, selamat datang di Strike Maniac! Terima kasih sudah bergabung dalam kegemaran kita memancing. Jika kamu belum bergabung bersama kami, ini adalah waktu yang tepat untuk menjelajahi dunia memancing! Mari kita dapatkan pengalaman dan kenangan baru bersama di Strike Maniac. Selamat memancing!";

                try {
                    $response = Http::post($endpoint, [
                        'api_key' => $apiKey,
                        'sender' => $sender,
                        'number' => $recipientNumber,
                        'message' => $message,
                    ]);

                } catch (\Exception $e) {
                    dd($e);
                    Alert::error('No connection', 'Please try again to Login')->persistent(true);

                    Auth::logout();
                    return redirect()->back();
                }

                return redirect('/event')->with(['success' => $request->name . "Selamat Datang"]);
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['erorr' => 'Username atau Password Salah']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('status', 'Anda berhasil logout.');
    }
}
