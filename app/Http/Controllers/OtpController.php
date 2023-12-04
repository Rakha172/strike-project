<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function index()
    {
        return view('login.otp');
    }

    private function generateOTP()
    {
        $otpCode = rand(100000, 999999);
        session(['otpCode' => $otpCode]);
        return $otpCode;
    }

    public function store(Request $request)
    {
        $request->validate([
            'otp_code' => 'required',
        ]);

        $inputOTP = $request->input('otp_code');
        $storedOTP = session('otpCode');

        if ($inputOTP == $storedOTP && session()->has('user_register')) {
            $request->session()->put('phone_number', $request->phone_number);

            User::create(session('user_register'));

            session()->remove('otpCode');
            session()->remove('user_register');

            return redirect()->route('login')->with('success', 'Kode OTP berhasil diverifikasi! Silakan masuk.');
        } else {
            return redirect()->back()->withErrors(['otp_code' => 'Kode OTP yang Anda masukkan tidak valid.']);
        }
    }
}

