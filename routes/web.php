<?php

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

// table events

Route::get('events', [EventController::class, 'index'])->name('event.index');
Route::get('events/create', [EventController::class, 'create'])->name('event.create');
Route::post('events', [EventController::class, 'store'])->name('event.store');
Route::get('events/{event}', [EventController::class, 'edit'])->name('event.edit');
Route::put('events/{event}', [EventController::class, 'update'])->name('event.update');
Route::delete('events/{event}', [EventController::class, 'destroy'])->name('event.destroy');