<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
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
            'email_or_phone_number' => 'required',
            'password' => 'required',
        ]);

        // check apakah input data berupa email
        $isEmail = \filter_var($credentials['email_or_phone_number'], FILTER_VALIDATE_EMAIL);

        // jika email, cek apakah email ada
        if ($isEmail)
        {
            $credentials = $this->emailIsExist($credentials['email_or_phone_number']);
        } else {
            // jika bukan email, cek apakah nomor hp ada
            $credentials = $this->phoneNumberIsExist($credentials['email_or_phone_number']);
        }

        if (!$credentials)
        {
            return back()->withErrors(['otp' => 'the email or password you entered is incorrect.'])->withInput();
        }

        $credentials = [
            'email' => $credentials->email,
            'password' => $request->post('password')
        ];

        $remember = $request->has('remember');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard')->with('success', 'Anda Berhasil Login!');
            } else if (Auth::user()->role == 'operator') {
                return redirect('/dashboard')->with(['succes' => $request->name . "Berhasil Login"]);
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

                return redirect('/event')->with(['success' =>'Welcome ' .  Auth::user()->name]);
              
            }
        } else {
            return back()->withErrors(['otp' => 'the email or password you entered is incorrect.'])->withInput();
        }
    }

    protected function phoneNumberIsExist($phoneNumber): User | null
    {
        $user = User::where('phone_number', $phoneNumber)->first();
        return $user;
    }

    protected function emailIsExist(string $email): User | null
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('logout', 'You Have Successfully Logout');
    }
}
