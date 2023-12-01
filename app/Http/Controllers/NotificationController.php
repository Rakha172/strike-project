<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use GuzzleHttp\Client;

class NotificationController extends Controller
{
    public function sendOTPviaWhatsApp($recipientNumber, $otpCode)
    {
        $setting = Setting::first();

        $apiKey = $setting->api_key;
        $sender = $setting->sender;
        $number = $recipientNumber;

        $message = "Hello, Strike Maniac!\n\n";
        $message .= "OTP Code: $otpCode\n\n";
        $message .= "Happy fishing and being a part of the amazing Strike Maniac community! 🎣";

        $client = new Client();

        $response = $client->post($setting->endpoint, [
            'form_params' => [
                'api_key' => $apiKey,
                'sender' => $sender,
                'number' => $number,
                'message' => $message,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
