<?php

use App\Http\Controllers\Event\EventChartResultAllController;
use App\Http\Controllers\Event\EventChartResultAndSpecialController;
use App\Http\Controllers\Event\EventChartResultAndTotalController;
use App\Http\Controllers\Event\EventChartResultAndTotalSpecialController;
use App\Http\Controllers\Event\EventChartResultController;
use App\Http\Controllers\Event\EventChartResultSpecialController;
use App\Http\Controllers\Event\EventChartResultTotalController;
use App\Http\Controllers\Event_RegistrationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SpinController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorController;
use App\Models\Event;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;



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

// table login register
Route::get('login', [LoginController::class, 'login'])->name('login.login');
Route::post('login', [LoginController::class, 'handleLogin'])->name('login');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.register');

// Logout
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

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

// reset password
// Route::get('/reset-password/{token', [AuthenticateController::class])->name('password.reset');
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

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
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

//LandingPage
Route::get('/', function () {
    return view('landingpage.index');
});

//landingpage
Route::get('/', function () {
    $setting = Setting::all();
    $events = Event::all();
    return view('landingpage.index', compact('setting', 'events'));
});

//dashboard
Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
});

//layout dashboard
Route::get('/layout', function () {
    return view('componen.layout');
});

//layout dashboard
Route::get('/main', function () {
    return view('componen.main');
});

//ROLE ADMIN//
// table user
Route::group(['middleware' => 'can:role,"admin"'], function () {
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user', [UserController::class, 'store'])->name('user.store');
    Route::get('user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    //table event
    Route::get('events', [EventController::class, 'index'])->name('event.index');
    Route::get('events/{id}/show', [EventController::class, 'show'])->name('event.show');
    Route::get('events/create', [EventController::class, 'create'])->name('event.create');
    Route::post('events', [EventController::class, 'store'])->name('event.store');
    Route::get('events/{event}', [EventController::class, 'edit'])->name('event.edit');
    Route::put('events/{event}', [EventController::class, 'update'])->name('event.update');
    Route::delete('events/{event}', [EventController::class, 'destroy'])->name('event.destroy');

    //table setting
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/create', [SettingController::class, 'create'])->name('setting.create');
    Route::post('setting', [SettingController::class, 'store'])->name('setting.store');
    Route::get('setting/{id}/show', [SettingController::class, 'show'])->name('setting.show');
    Route::get('setting/{id}/edit', [SettingController::class, 'edit'])->name('setting.edit');
    Route::put('setting/{id}', [SettingController::class, 'update'])->name('setting.update');

    //table result
    Route::get('result/{event}', [ResultController::class, 'index'])->name('result.index');
    Route::get('/result/{event}/create', [ResultController::class, 'create'])->name('result.create');
    Route::post('result/{event}', [ResultController::class, 'store'])->name('result.store');
    Route::get('result/{result}/{event}', [ResultController::class, 'edit'])->name('result.edit');
    Route::put('result/{result}', [ResultController::class, 'update'])->name('result.update');
    Route::delete('result/{result}', [ResultController::class, 'destroy'])->name('result.destroy');

    //table payment
    Route::get('payment-confirm', [PaymentController::class, 'index'])->name('payment.index');
    Route::put('payment-confirm/{event_registrationId}', [PaymentController::class, 'update'])->name('payment.update');
    Route::put('/payment/cancel/{event_registrationId}', [PaymentController::class, 'cancel'])->name('payment.cancel');

    //Halaman RegisEvent
    Route::get('event-registration', [Event_RegistrationController::class, 'index'])->name('event_registration.index');
});

//ROLE MEMBER//
// table event registration
Route::group(['middleware' => 'can:role,"member"'], function () {
    Route::get('/landingevent', [Event_RegistrationController::class, 'create'])->name('landingevent');
    Route::post('/store-event-registration', [Event_RegistrationController::class, 'storeEventRegistration'])->name('store-event-registration');
    Route::get('event-registration/{event_registration}', [Event_RegistrationController::class, 'edit'])->name('event_registration.edit');
    Route::put('event-registration/{event_registration}', [Event_RegistrationController::class, 'update'])->name('event_registration.update');
    Route::delete('event-registration/{event_registration}', [Event_RegistrationController::class, 'destroy'])->name('event_registration.destroy');


    //event untuk landingevent
    Route::get('/event', function () {
        $events = Event::all();
        return view('landingevent.landingevent', compact('events'));
    })->name('events');

    //spinner
    Route::get('/spin', [SpinController::class, 'spin'])->name('spin.spin');
    Route::post('/reduce-both/{eventId}', 'EventController@reduceBoth');
});

//ROLE OPERATOR//
Route::group(['middleware' => 'can:role,"operator"'], function () {
    //table event
    Route::get('/eventsop', [OperatorController::class, 'index'])->name('eventsop.index');

    //table result
    Route::get('resultop/{event}', [OperatorController::class, 'indexop'])->name('resultop.index');
    Route::get('/resultop/{event}/create', [OperatorController::class, 'create'])->name('resultop.create');
    Route::post('resultop/{event}', [ResultController::class, 'store'])->name('resultop.store');
    Route::get('resultop/{result}/{event}', [OperatorController::class, 'edit'])->name('resultop.edit');
    Route::put('resultop/{result}', [OperatorController::class, 'update'])->name('resultop.update');

    //scan
    Route::get('/operator/attended', [OperatorController::class, 'showAttendedPage'])->name('operator.attended');
    Route::post('/operator/attended', [OperatorController::class, 'scan'])->name('operator.scan');
    Route::get('/operator/attended', [OperatorController::class, 'showAttendedPage'])->name('operator.attended');
    Route::post('/operator/scan', [OperatorController::class, 'scan'])->name('operator.scan');
});

//ROLE ADMIN-OPERATOR CHART//
Route::group(['middleware' => 'can:role,"operator", "admin"'], function () {
    //event chart result
    Route::get('events/{event}/chart-result', EventChartResultController::class)->name('events.chart-result');
    Route::get('events/{event}/chart-total', EventChartResultTotalController::class)->name('events.chart-total');
    Route::get('events/{event}/chart-special', EventChartResultSpecialController::class)->name('events.chart-special');
    Route::get('events/{event}/chart-combined', EventChartResultAllController::class)->name('events.chart-combined');
    Route::get('events/{event}/chart-result-and-special', EventChartResultAndSpecialController::class)->name('events.chart-result-and-special');
    Route::get('events/{event}/chart-result-and-total', EventChartResultAndTotalController::class)->name('events.chart-result-and-total');
    Route::get('events/{event}/chart-result-and-total-special', EventChartResultAndTotalSpecialController::class)->name('events.chart-result-and-total-special');
});
