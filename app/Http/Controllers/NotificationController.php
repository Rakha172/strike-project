<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\WhatsappPasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function forgotPassword(Request $request)
    {
        $setting = Setting::first();

        $request->validate([
            'email_or_whatsapp' => 'required',
        ], [
            'email_or_whatsapp' => "Email or WhatsApp is required.",
        ]);
        $input = $request->input('email_or_whatsapp');

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $status = Password::sendResetLink(['email' => $input]);
        } else {
            $user = User::query()
                ->where('phone_number', $input)
                ->first();

            if ($user) {
                $userName = $user->name;
                $userPhoneNumber = $user->phone_number;

                $newToken = Str::random(60);
                $checkExistPhone = WhatsappPasswordReset::query()
                    ->where('phone_number', $userPhoneNumber)
                    ->latest()
                    ->first();

                if ($checkExistPhone) {
                    $addToken = $checkExistPhone->update([
                        'token' => $newToken,
                    ]);
                    $token = $checkExistPhone->token;
                } else {
                    $addToken = WhatsappPasswordReset::create([
                        'phone_number' => $userPhoneNumber,
                        'token' => $newToken,
                    ]);

                    $token = $addToken->token;
                }

                $resetLink = route('password.reset', ['token' => $token, 'phone_number' => $user->phone_number]);

                $apiKey = $setting->api_key;
                $sender = $setting->sender;
                $number = $userPhoneNumber;

                $message = "Hello, $user->name strike maniac!\n\n";
                $message .= "You have requested a password reset for your strike maniac account.\n\n";
                $message .= "Click the following link to reset your password: $resetLink\n\n";
                $message .= "If you did not request a password reset, please ignore this message.\n\n";
                $message .= "Thank you for being a part of strike maniac!\n";

                $client = new Client();

                $response = $client->post($setting->endpoint, [
                    'form_params' => [
                        'api_key' => $apiKey,
                        'sender' => $sender,
                        'number' => $number,
                        'message' => $message,
                    ],
                ]);
                $responseBody = json_decode($response->getBody(), true);

                echo "<script>
                    Swal.fire({
                        icon: '" . ($responseBody['status'] ? 'success' : 'error') . "',
                        title: '" . ($responseBody['status'] ? 'Success' : 'Error') . "',
                        text: '" . $responseBody['msg'] . "',
                    });
                </script>";
            }
        }
        return view('auth.forgot-password')->with('success', 'The link to reset your password has been sent to your email/Whatsapp');
    }

    public function processResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $isEmail = $request->input('email');
        $isWhatsapp = $request->input('phone_number');

        if ($isEmail) {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    event(new PasswordReset($user));
                }
            );

            return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', 'Password reset successful')
                : back()->withErrors(['email' => __($status)]);
        } else {
            $token = $request->token;
            $confirmToken = WhatsappPasswordReset::query()
                ->where('token', $token)
                ->latest()
                ->first();

            if ($confirmToken) {
                $user = User::query()
                    ->where('phone_number', $isWhatsapp)
                    ->latest()
                    ->first();

                $user->update([
                    'password' => Hash::make($request->password),
                ]);

                return redirect()->route('login')->with('status', 'Password reset successful');
            } else {
                return back()->withErrors("Invalid token");
            }
        }
    }
}
