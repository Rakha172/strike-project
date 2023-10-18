<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class AuthenticateController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }
}
