<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

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
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
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
                $message = "Hai {$user->name} 🎣 \n\n";
                $message .= "Selamat datang di Strike Maniac!\n";
                $message .= "Terima kasih sudah bergabung dalam kegemaran kita memancing,";
                $message .= " mari kita dapatkan pengalaman dan kenangan baru bersama di Strike Maniac.\n\n";
                $message .= "Selamat memancing!";

                try {
                    $response = Http::post($endpoint, [
                        'api_key' => $apiKey,
                        'sender' => $sender,
                        'number' => $recipientNumber,
                        'message' => $message,
                    ]);
                } catch (\Exception $e) {
                    Alert::error('No connection', 'Please try again to Login')->persistent(true);

                    Auth::logout();
                    return redirect()->back();
                }

                return redirect('/event')->with(['success' => 'Welcome ' . Auth::user()->name]);

            }
        } else {
            return back()->withErrors(['otp' => 'the email or password you entered is incorrect.'])->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('logout', 'You Have Successfully Logout');
    }
}
