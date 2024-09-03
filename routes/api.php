<?php

use App\Http\Controllers\Api\V1\Calendar\CalendarController;
use App\Http\Controllers\Api\V1\Calendar\DataController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);

    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');

});


Route::prefix('admin')->as('api.')->middleware('jwt.auth')->namespace('App\Http\Controllers\Api\V1')->group(function () {
    Route::prefix('calendar')->as('calendar.')->namespace('Calendar')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index');
        Route::get('/type', [DataController::class, 'getTypes'])->name('types');
        Route::get('/status', [DataController::class, 'getStatuses'])->name('statuses');
    });
});
