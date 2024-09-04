<?php

use App\Http\Controllers\Api\V1\Calendar\CalendarController;
use App\Http\Controllers\Api\V1\Calendar\DataController;
use App\Http\Controllers\Api\V1\Calendar\EventController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('api')->group(function ($router) {
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('admin')->as('api.')->middleware('jwt.auth')->namespace('App\Http\Controllers\Api\V1')->group(function () {
    Route::prefix('calendar')->as('calendar.')->namespace('Calendar')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index');
        Route::get('/day', [CalendarController::class, 'showDay'])->name('showday');
    });

    Route::prefix('event')->as('event.')->namespace('Event')->group(function () {
        Route::get('/type', [DataController::class, 'getTypes'])->name('types');
        Route::get('/status', [DataController::class, 'getStatuses'])->name('statuses');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::post('/', [EventController::class, 'create'])->name('create');
        Route::patch('/{event}/edit', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'delete'])->name('delete');
    });
});
