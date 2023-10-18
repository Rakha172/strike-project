<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// table login

Route::get('login', [LoginController::class, 'login'])->name('login.login');
Route::post('login', [LoginController::class, 'handleLogin'])->name('login');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// forgot password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

// table events

Route::get('events', [EventController::class, 'index'])->name('event.index');
Route::get('events/create', [EventController::class, 'create'])->name('event.create');
Route::post('events', [EventController::class, 'store'])->name('event.store');
Route::get('events/{event}', [EventController::class, 'edit'])->name('event.edit');
Route::put('events/{event}', [EventController::class, 'update'])->name('event.update');
Route::delete('events/{event}', [EventController::class, 'destroy'])->name('event.destroy');
