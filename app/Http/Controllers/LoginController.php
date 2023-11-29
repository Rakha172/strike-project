<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
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
                return redirect('/event')->with(['success' => $request->name . "Selamat Datang"]);
            }
            if (Auth::guard('web')->attempt($credentials)) {
                $user = Auth::guard('web')->user();

                if ($user->role === 'member') {
                    $recipientNumber = $user->phone_number;
                    $message = "🎣 Hai {$user->name}, selamat datang di Strike Maniac! Terima kasih sudah bergabung dalam kegemaran kita memancing. Jika kamu belum bergabung bersama kami, ini adalah waktu yang tepat untuk menjelajahi dunia memancing! Mari kita dapatkan pengalaman dan kenangan baru bersama di Strike Maniac. Selamat memancing!";

                    $client = new Client();

                    try {
                        $response = $client->post($setting->endpoint, [
                            'form_params' => [
                                'api_key' => $apiKey,
                                'sender' => $sender,
                                'number' => $recipientNumber,
                                'message' => $message,
                            ],
                        ]);
                    } catch (\Exception $e) {
                        Alert::error('No connection', 'Please try again to Login')->persistent(true);
                        return redirect()->back();
                    }
                }

                return redirect()->route('dashboard');
            } else {
                return back()->withErrors(['otp' => 'The password you entered is incorrect.'])->withInput();
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('status', 'Anda berhasil logout.');
    }
}

