<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;

class RegisterController extends Controller
{
    private function generateOTP()
    {
        $otpCode = rand(100000, 999999);
        session(['otpCode' => $otpCode]);
        return $otpCode;
    }

    public function showRegistrationForm()
    {
        $title = Setting::firstOrFail();
        return view('register.register', compact('title'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'email' => 'required|string|email|max:255',

        ], [
            'name.required' => 'Username wajib diisi',
            'phone_number.required' => 'Nomor Telepon wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email berupa email.',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_confirmation' => 'Konfirmasi password tidak cocok',

        ]);

        $otpCode = $this->generateOTP();
        $recipientNumber = $request->phone_number;

        session([
            'user_register' => [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]
        ]);

        $notificationController = new NotificationController();
        try {
            $notificationController->sendOTPviaWhatsApp($recipientNumber, $otpCode);

            return redirect()->route('login.otp')->with(['success' => $request->name . " Berhasil Registrasi"]);
        } catch (\Exception $e) {
            // Tindakan yang sesuai jika pengiriman OTP gagal
            return redirect()->back()->with('error', 'Gagal mengirim OTP');
        }
    }
}
