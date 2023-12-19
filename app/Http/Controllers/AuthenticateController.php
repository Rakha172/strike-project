<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class AuthenticateController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetPasswordWhatsApp(Request $request)
    {
        // Data yang akan dikirimkan via WhatsApp
        $phoneNumber = $request->input('phone_number'); // Ganti dengan nomor yang dituju
        $resetLink = 'http://127.0.0.1:8000/forgot-password'; // Ganti dengan link reset password yang valid

        // Data untuk dikirim melalui API kantor Anda
        $setting = Setting::first();
        $apiKey = $setting->api_key; // Ganti dengan API key dari kantor Anda

        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        $message = "Klik link berikut untuk mereset password Anda: $resetLink";

        try {
            $response = $client->post('https://api.whatsapp.com/your-endpoint', [
                'json' => [
                    'phone_number' => $phoneNumber,
                    'message' => $message,
                ],
            ]);

            return response()->json(['message' => 'Reset link sent via WhatsApp!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to send reset link'], 500);
        }
    }
}
