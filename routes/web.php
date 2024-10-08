<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Calendar\CalendarController;
use App\Http\Controllers\Calendar\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

Route::get('/', HomeController::class)->name('home');;

// Authentication pages
Route::prefix('auth')->as('auth.')->namespace('App\Http\Controllers\Auth')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'registerPost'])->name('register.post');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::post('/get-user-token', [AuthController::class, 'getUserToken']);
});

// Admin dashboard. Need log in
Route::prefix('admin')->as('admin.')->namespace('App\Http\Controllers')->middleware('auth')->group(function () {
    Route::prefix('calendar')->as('calendar.')->namespace('Calendar')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index');
        Route::get('/day', [CalendarController::class, 'showDay'])->name('showday');
    });

    Route::prefix('events')->as('event.')->namespace('Calendar')->group(function () {
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::get('/{event}', [EventController::class, 'edit'])->name('edit');
        Route::post('/create', [EventController::class, 'store'])->name('store');
        Route::patch('/{event}/edit', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'delete'])->name('delete');
    });
});
