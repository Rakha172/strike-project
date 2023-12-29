<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Event\EventChartResultAndTotalSpecialController;
use App\Http\Controllers\Event\EventChartResultAndSpecialController;
use App\Http\Controllers\Event\EventChartResultAndTotalController;
use App\Http\Controllers\Event\EventChartResultSpecialController;
use App\Http\Controllers\Event\EventChartResultTotalController;
use App\Http\Controllers\Event\EventChartResultAllController;
use App\Http\Controllers\Event\EventChartResultController;
use App\Http\Controllers\Event_RegistrationController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\RundownController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Models\Event_Registration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\SpinController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\PaymentTypeController;

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

//Kode Otp
Route::post('/login', [LoginController::class, 'handleLogin'])->name('login.store');
Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::post('/login/otp', [OtpController::class, 'store'])->name('login.otp.store');
Route::get('/login/otp', [OtpController::class, 'index'])->name('login.otp');

Route::post('/send-reset-password-whatsapp', [ForgotController::class, 'sendResetPasswordWhatsApp'])
    ->name('send.reset.password.whatsapp');

// reset password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', [NotificationController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', [NotificationController::class, 'processResetPassword'])->name('password.update');
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

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

    //crud payment types
    Route::get('paymentypes', [PaymentTypeController::class, 'paymenttypesIndex'])->name('paymenttypesIndex');
    Route::get('paymentypes/create', [PaymentTypeController::class, 'create'])->name('paytype.create');
    Route::post('paymentypes', [PaymentTypeController::class, 'store'])->name('paytype.store');
    Route::get('paymentypes/{paymenttypes}', [PaymentTypeController::class, 'edit'])->name('paytype.edit');
    Route::put('paymentypes/{paymenttypes}', [PaymentTypeController::class, 'paytypeupdate'])->name('paytypeupdate');
    Route::delete('paymentypes/{paymenttypes}', [PaymentTypeController::class, 'destroy'])->name('paytype.destroy');

    //payment-member
});

//ROLE MEMBER//
// table event registration
Route::group(['middleware' => 'can:role,"member"'], function () {
    Route::get('regisevent', [Event_RegistrationController::class, 'create'])->name('regisevent');
    Route::post('event-registration', [Event_RegistrationController::class, 'store'])->name('event_registration.store');
    Route::get('event-registration/{event_registration}', [Event_RegistrationController::class, 'edit'])->name('event_registration.edit');
    Route::put('event-registration/{event_registration}', [Event_RegistrationController::class, 'update'])->name('event_registration.update');
    Route::delete('event-registration/{event_registration}', [Event_RegistrationController::class, 'destroy'])->name('event_registration.destroy');

    //landingevent
    Route::get('/event', function () {
        return view('landingevent.landingevent');
    });

    //event untuk landingevent
    Route::get('/event', function () {
        $events = Event::all();
        $events_registration = Event_Registration::all();
        $user = Auth::user();
        return view('landingevent.landingevent', compact('events', 'events_registration', 'user'));
    })->name('events');

    //updateprofileuser
    Route::put('landingevent/{user}', [UserController::class, 'updateprofile'])->name('updateprofile');

    //spinner
    Route::post('/reduce-both/{eventId}', 'EventController@reduceBoth');


});

Route::get('/payment/{event_register_id}', [PaymentController::class, 'member'])->name('payment');
Route::put('/payment/{event_register_id}', [PaymentController::class, 'updatePayment'])->name('updatePayment');
Route::get('/payment-confirm/{event_register_id}', [PaymentController::class, 'paymentConfirm'])->name('paymentConfirm');
Route::get('/countdown/{id}', function ($id) {
});

Route::put('expired-order/{orderManifestId}', [PaymentController::class, 'expiredOrder'])->name('order.expiredOrder');

//ROLE OPERATOR//
Route::group(['middleware' => 'can:role,"operator"'], function () {
    //table event
    Route::get('/eventsop', [OperatorController::class, 'index'])->name('eventsop.index');

    //table result
    Route::get('resultop/{event}', [OperatorController::class, 'indexop'])->name('resultop.index');
    Route::get('/resultop/{event}/create', [OperatorController::class, 'create'])->name('resultop.create');
    Route::post('resultop/{event}', [OperatorController::class, 'store'])->name('resultop.store');
    Route::get('resultop/{result}/{event}', [OperatorController::class, 'edit'])->name('resultop.edit');
    Route::put('resultop/{result}', [OperatorController::class, 'update'])->name('resultop.update');

    //chart-result-operator
    // Route::get('events/{event}/chart-resultop', OperatorController::class)->name('events.chart-resultop');

    Route::get('/operator/attended', [OperatorController::class, 'showAttendedPage'])->name('operator.attended');
    Route::post('/operator/attended', [OperatorController::class, 'scan'])->name('operator.scan');
    Route::get('/operator/attended', [OperatorController::class, 'showAttendedPage'])->name('operator.attended');
    Route::post('/operator/scan', [OperatorController::class, 'scan'])->name('operator.scan');
    Route::get('/operator/rundown/{eventId}/{eventRegistrationId}', [RundownController::class, 'index'])->name('operator.rundown');
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

