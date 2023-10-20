<?php

use App\Http\Controllers\Event_RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
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



//dashboard
// Route::group(['middleware' => 'can:role,"admin"'], function () {
Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
});
// });

// table user
Route::get('user', [UserController::class, 'index'])->name('user.index');
Route::get('user/create', [UserController::class, 'create'])->name('user.create');
Route::post('user', [UserController::class, 'store'])->name('user.store');
Route::get('user/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

// table events
// Route::group(['middleware' => 'can:role,"member"'], function () {
Route::get('events', [EventController::class, 'index'])->name('event.index');
Route::get('events/create', [EventController::class, 'create'])->name('event.create');
Route::post('events', [EventController::class, 'store'])->name('event.store');
Route::get('events/{event}', [EventController::class, 'edit'])->name('event.edit');
Route::put('events/{event}', [EventController::class, 'update'])->name('event.update');
Route::delete('events/{event}', [EventController::class, 'destroy'])->name('event.destroy');
// });

// table setting
// Route::group(['middleware' => 'can:role,"admin"'], function () {
Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
Route::get('setting/create', [SettingController::class, 'create'])->name('setting.create');
Route::post('setting', [SettingController::class, 'store'])->name('setting.store');
Route::get('setting/{setting}', [SettingController::class, 'edit'])->name('setting.edit');
Route::put('setting/{setting}', [SettingController::class, 'update'])->name('setting.update');
Route::delete('setting/{setting}', [SettingController::class, 'destroy'])->name('setting.destroy');
// });

// table event registration
Route::get('event_registration', [Event_RegistrationController::class, 'index'])->name('event_registration.index');
Route::get('event_registration/create', [Event_RegistrationController::class, 'create'])->name('event_registration.create');
Route::post('event_registration', [Event_RegistrationController::class, 'store'])->name('event_registration.store');
Route::get('event_registration/{event_registration}', [Event_RegistrationController::class, 'edit'])->name('event_registration.edit');
Route::put('event_registration/{event_registration}', [Event_RegistrationController::class, 'update'])->name('event_registration.update');
Route::delete('event_registration/{event_registration}', [Event_RegistrationController::class, 'destroy'])->name('event_registration.destroy');
