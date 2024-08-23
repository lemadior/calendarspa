<?php

use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});


// Authentication pages
// Route::prefix('auth')->as('auth.')->namespace('App\Http\Controllers\Auth')->group(function() {
//     Route::get('/login', [LoginController::class, 'login'])->name('login');
//     Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
//     Route::get('/register', [RegisterController::class, 'register'])->name('register');
//     Route::post('/register', [RegisterController::class, 'registerPost'])->name('register.post');
//     Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
// });
